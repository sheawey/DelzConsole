<?php

namespace Delz\Console\Output;

use Delz\Console\Contract\IFormatter;
use Delz\Console\Contract\IOutput;
use Delz\Console\Exception\RuntimeException;

/**
 * 流输出
 *
 * @package Delz\Console\Output
 */
class Stream extends Base implements IOutput
{
    /**
     * 流
     *
     * @var resource
     */
    private $stream;

    /**
     * @param bool|int|null $verbosity 信息冗余度阈值
     * @param IFormatter|null $formatter 格式化对象
     */
    public function __construct($verbosity = IOutput::VERBOSITY_NORMAL, IFormatter $formatter = null)
    {
        $this->stream = $this->openOutputStream();

        parent::__construct($verbosity, $formatter);
    }

    /**
     * 获取流对象
     *
     * @return resource
     */
    public function getStream()
    {
        return $this->stream;
    }

    /**
     * 是否指出php标准输出
     *
     * @return bool
     */
    protected function hasStdoutSupport()
    {
        return false === $this->isRunningOS400();
    }

    /**
     * 判断运行环境是否是IBM iSeries (OS400)
     *
     * @return bool
     */
    private function isRunningOS400()
    {
        $checks = [
            function_exists('php_uname') ? php_uname('s') : '',
            getenv('OSTYPE'),
            PHP_OS,
        ];

        return false !== stripos(implode(';', $checks), 'OS400');
    }

    /**
     * 打开php标准输出流
     *
     * @return resource
     */
    private function openOutputStream()
    {
        if (!$this->hasStdoutSupport()) {
            return fopen('php://output', 'w');
        }

        return @fopen('php://stdout', 'w') ?: fopen('php://output', 'w');
    }

    /**
     * {@inheritdoc}
     */
    protected function doWrite($messages, $newline)
    {
        if (false === @fwrite($this->stream, $messages) || ($newline && (false === @fwrite($this->stream, PHP_EOL)))) {
            throw new RuntimeException('Unable to write output.');
        }

        fflush($this->stream);
    }

}