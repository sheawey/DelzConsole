<?php

namespace Delz\Console\Output;

use Delz\Console\Contract\IOutput;
use Delz\Console\Contract\IFormatter;
use Delz\Console\Exception\RuntimeException;
use Delz\Console\Output\Formatter\Formatter;

/**
 * 命令行输出抽象基类
 *
 * @package Pitaya\Component\Console\Output
 */
abstract class Base implements IOutput
{
    /**
     * 输出信息冗余度阈值
     *
     * @var int
     */
    private $verbosity;

    /**
     * 信息格式
     *
     * @var IFormatter
     */
    private $formatter;

    /**
     * @param int $verbosity 信息冗余度阈值
     * @param IFormatter|null $formatter 格式化对象
     */
    public function __construct($verbosity = IOutput::VERBOSITY_NORMAL, IFormatter $formatter= null)
    {
        $this->verbosity = null === $verbosity ? IOutput::VERBOSITY_NORMAL : $verbosity;
        $this->formatter = $formatter ?: new Formatter();
        $decorated = $this->hasColorSupport();
        $this->formatter->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function write($messages, $newline = false, $type = IOutput::OUTPUT_NORMAL)
    {
        $messages = (array)$messages;

        $types = IOutput::OUTPUT_NORMAL | IOutput::OUTPUT_RAW | IOutput::OUTPUT_PLAIN;
        $type = $types & $type ?: IOutput::OUTPUT_NORMAL;

        foreach($messages as $message) {
            switch ($type) {
                case IOutput::OUTPUT_NORMAL:
                    $message = $this->formatter->format($message);
                    break;
                case IOutput::OUTPUT_RAW:
                    //不用处理$message
                    break;
                case IOutput::OUTPUT_PLAIN:
                    $message = strip_tags($this->formatter->format($message));
                    break;
            }
            $this->doWrite($message, $newline);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function writeln($messages, $type = IOutput::OUTPUT_NORMAL)
    {
        $this->write($messages, true, $type);
    }

    /**
     * {@inheritdoc}
     */
    public function getVerbosity()
    {
        return $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function setVerbosity($level)
    {
        $this->verbosity = (int)$level;
    }

    /**
     * {@inheritdoc}
     */
    public function isQuiet()
    {
        return IOutput::VERBOSITY_QUIET === $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isVerbose()
    {
        return IOutput::VERBOSITY_VERBOSE <= $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isVeryVerbose()
    {
        return IOutput::VERBOSITY_VERY_VERBOSE <= $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function isDebug()
    {
        return IOutput::VERBOSITY_DEBUG <= $this->verbosity;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormatter()
    {
        return $this->formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function setFormatter(IFormatter $formatter)
    {
        $this->formatter = $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function setDecorated($decorated)
    {
        $this->formatter->setDecorated($decorated);
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->formatter->isDecorated();
    }

    /**
     * 判断输入是否支持颜色
     */
    protected function hasColorSupport()
    {
        if (DIRECTORY_SEPARATOR === '\\') {
            return
                0 >= version_compare('10.0.10586', PHP_WINDOWS_VERSION_MAJOR.'.'.PHP_WINDOWS_VERSION_MINOR.'.'.PHP_WINDOWS_VERSION_BUILD)
                || false !== getenv('ANSICON')
                || 'ON' === getenv('ConEmuANSI')
                || 'xterm' === getenv('TERM');
        }

        return true;
    }

    /**
     * 输出信息
     *
     * @param string $messages 命令行要输出的信息
     * @param bool $newline 是否在最后添加一个空行
     * @throws RuntimeException 如果无法写入，抛出异常
     */
    abstract protected function doWrite($messages, $newline);

}