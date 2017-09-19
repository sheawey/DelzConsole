<?php

namespace Delz\Console\Output\Formatter;

use Delz\Console\Contract\IFormatter;
use Delz\Console\Contract\IFormatterStyle;
use Delz\Console\Exception\InvalidArgumentException;

/**
 * 格式化信息类
 *
 * @package Delz\Console\Output\Formatter
 */
class Formatter implements IFormatter
{
    /**
     * 是否采用装饰输出
     *
     * @var bool
     */
    private $decorated;

    /**
     * 输出样式数组
     *
     * @var IFormatterStyle[]
     */
    private $styles = [];

    /**
     * 样式栈
     *
     * @var Stack
     */
    private $stack;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->setStyle('error', new Style('white', 'red'));
        $this->setStyle('info', new Style('green'));
        $this->setStyle('comment', new Style('yellow'));
        $this->setStyle('question', new Style('black', 'cyan'));

        $this->stack = new Stack();
    }

    /**
     * {@inheritdoc}
     */
    public function format($message)
    {
        $message = (string)$message;
        $offset = 0; //文字偏移量
        $output = ''; //格式化要输出的文本
        $tagRegex = '[a-z][a-z0-9=;-_,]*'; //要格式化的文本标记
        preg_match_all("#<(($tagRegex)|/($tagRegex)?)>#ix", $message, $matches, PREG_OFFSET_CAPTURE);
        foreach ($matches[0] as $i => $match) {
            $pos = $match[1];
            $text = $match[0];

            $output .= $this->applyCurrentStyle(substr($message, $offset, $pos - $offset));
            $offset = $pos + strlen($text);

            if ($open = '/' != $text[1]) {
                $tag = $matches[1][$i][0];
            } else {
                $tag = isset($matches[3][$i][0]) ? $matches[3][$i][0] : '';
            }

            if (!$open && !$tag) {
                // </>
                $this->stack->pop();
            } elseif (false === $style = $this->createStyleFromTag($tag)) {
                $output .= $this->applyCurrentStyle($text);
            } elseif ($open) {
                $this->stack->push($style);
            } else {
                $this->stack->pop($style);
            }
        }

        $output .= $this->applyCurrentStyle(substr($message, $offset));

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function setDecorated($decorated)
    {
        $this->decorated = (bool)$decorated;
    }

    /**
     * {@inheritdoc}
     */
    public function isDecorated()
    {
        return $this->decorated;
    }

    /**
     * {@inheritdoc}
     */
    public function setStyle($name, IFormatterStyle $style)
    {
        $this->styles[strtolower($name)] = $style;
    }

    /**
     * {@inheritdoc}
     */
    public function hasStyle($name)
    {
        return isset($this->styles[strtolower($name)]);
    }

    /**
     * {@inheritdoc}
     */
    public function getStyle($name)
    {
        if (!$this->hasStyle($name)) {
            throw new InvalidArgumentException(sprintf('Undefined style: %s', $name));
        }

        return $this->styles[strtolower($name)];
    }

    /**
     * 根据样式标记创建样式对象
     *
     * @param string $tag 样式标记
     * @return IFormatterStyle|bool
     */
    private function createStyleFromTag($tag)
    {
        $tag = strtolower($tag);
        if (isset($this->styles[$tag])) {
            return $this->styles[$tag];
        }

        if (!preg_match_all('/([a-z]+)=([a-z,]+)?/', $tag, $matches, PREG_SET_ORDER)) {

            return false;
        }

        $style = new Style();
        foreach ($matches as $match) {
            array_shift($match);
            switch ($match[0]) {
                case 'fg':
                    $style->setForeground($match[1]);
                    break;
                case 'bg':
                    $style->setBackground($match[1]);
                    break;
                case 'options':
                    //多个option逗号分隔
                    $options = explode(',', $match[1]);
                    $style->setOptions($options);
                    break;
                default:
                    return false;
            }
        }
        return $style;
    }

    /**
     * 用样式栈中的当前栈格式化文本
     *
     * @param string $text 要格式化的文本
     * @return string
     */
    private function applyCurrentStyle($text)
    {
        return $this->isDecorated() && strlen($text) > 0 ? $this->stack->getCurrent()->apply($text) : $text;
    }
}