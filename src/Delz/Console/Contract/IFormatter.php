<?php

namespace Delz\Console\Contract;

/**
 * 命令输出格式接口类
 *
 * @package Delz\Console\Contract
 */
interface IFormatter
{
    /**
     * 格式化信息
     *
     * @param string $message 要格式化的信息
     * @return string 格式化后的信息
     */
    public function format($message);

    /**
     * 设置是否装饰输出
     *
     * 指输出前景色，背景色以及各种控制选项，某些命令行不支持
     *
     * @param bool $decorated
     */
    public function setDecorated($decorated);

    /**
     * 是否装饰输出
     *
     * 指输出前景色，背景色以及各种控制选项，某些命令行不支持
     *
     * @return bool
     */
    public function isDecorated();

    /**
     * 添加样式
     *
     * @param string $name 样式名称
     * @param IFormatterStyle $style 样式对象
     */
    public function setStyle($name, IFormatterStyle $style);

    /**
     * 判断是否存在样式
     *
     * @param string $name 样式名称
     * @return bool
     */
    public function hasStyle($name);

    /**
     * 根据样式名称获取样式对象
     *
     * @param string $name 样式名称
     * @return IFormatterStyle
     */
    public function getStyle($name);
}