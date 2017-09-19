<?php

namespace Delz\Console\Contract;

/**
 * 命令行输入参数接口类
 *
 * @package Delz\Console\Contract
 */
interface IInput extends \ArrayAccess
{
    /**
     * 获取第一个参数
     *
     * @return string
     */
    public function getFirstArgument();

    /**
     * 获取所有参数
     *
     * @return array
     */
    public function getArguments();

    /**
     * 根据$name获取参数的值
     *
     * @param string $name
     * @return mixed
     */
    public function getArgument($name);

    /**
     * 判断是否存在$name的参数
     *
     * @param string|array $name
     * @return bool
     */
    public function hasArgument($name);

    /**
     * 设置参数值
     *
     * @param string $name
     * @param string $value
     */
    public function setArgument($name, $value);
}