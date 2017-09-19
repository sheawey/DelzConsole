<?php

namespace Delz\Console\Contract;

use Delz\Console\Exception\InvalidArgumentException;

/**
 * 格式样式接口类
 *
 * @package Pitaya\Component\Console\Contract
 */
interface IFormatterStyle
{
    /**
     * 设置文字颜色
     *
     * @param null|string $color 文字颜色
     * @throws InvalidArgumentException 如果文字颜色不符合，抛出异常
     */
    public function setForeground($color = null);

    /**
     * 设置背景颜色
     *
     * @param null|string $color 背景颜色
     * @throws InvalidArgumentException 如果背景颜色不符合，抛出异常
     */
    public function setBackground($color = null);

    /**
     * 设置所有控制选项
     *
     * @param array $options 控制选项
     * @throws InvalidArgumentException 会依次调用self::setOption($option),所以可能抛出异常
     */
    public function setOptions(array $options);

    /**
     * 设置单个控制选项
     *
     * @param string $option 控制选项名称
     * @throws InvalidArgumentException 如果控制选项不符合，抛出异常
     */
    public function setOption($option);

    /**
     * 删除单个控制选项
     *
     * @param string $option 控制选项名称
     * @throws InvalidArgumentException 如果控制选项不符合，抛出异常
     */
    public function unsetOption($option);

    /**
     * 将文本转化为命令行文本
     *
     * @param string $text 要转化的文本
     * @return string 转换好的文本
     */
    public function apply($text);
}