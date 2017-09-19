<?php

namespace Delz\Console\Output\Formatter;

use Delz\Console\Contract\IFormatterStyle;
use Delz\Console\Exception\InvalidArgumentException;

/**
 * 命令样式栈
 *
 * @package Delz\Console\Output\Formatter
 */
class Stack
{
    /**
     * @var IFormatterStyle[]
     */
    private $styles = [];

    /**
     * @var IFormatterStyle
     */
    private $emptyStyle;

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->emptyStyle = new Style();
    }

    /**
     * 将样式入栈
     *
     * @param IFormatterStyle $style
     */
    public function push(IFormatterStyle $style)
    {
        $this->styles[] = $style;
    }

    /**
     * 样式出栈
     *
     * @param IFormatterStyle|null $style
     * @return IFormatterStyle
     */
    public function pop(IFormatterStyle $style = null)
    {
        if (empty($this->styles)) {
            return $this->emptyStyle;
        }

        if (null === $style) {
            return array_pop($this->styles);
        }

        foreach (array_reverse($this->styles, true) as $k => $stackedStyle) {
            if ($stackedStyle->apply('') === $style->apply('')) {
                $this->styles = array_slice($this->styles, 0, $k);
            }

            return $stackedStyle;
        }

        throw new InvalidArgumentException('Incorrectly nested style tag found.');
    }

    /**
     * 获取栈的当前样式
     *
     * @return IFormatterStyle
     */
    public function getCurrent()
    {
        if (empty($this->styles)) {
            return $this->emptyStyle;
        }

        return $this->styles[count($this->styles) - 1];
    }

}