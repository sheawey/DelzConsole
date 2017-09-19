<?php

namespace Delz\Console\Contract;

/**
 * 所有命令的接口
 *
 * @package Delz\Console\Contract
 */
interface ICommand
{
    /**
     * 执行命令
     *
     * @param IInput|null $input
     * @param IOutput|null $output
     */
    public function run(IInput $input = null, IOutput $output = null);

    /**
     * 获取命令名称
     *
     * @return string
     */
    public function getName();

    /**
     * 设置命令名称
     *
     * @param string $name
     * @return self
     */
    public function setName($name);

    /**
     * 添加别名
     *
     * @param string $alias
     * @return self
     */
    public function addAlias($alias);

    /**
     * 获取所有别名
     *
     * @return array
     */
    public function getAliases();

    /**
     * 批量设置别名
     *
     * @param array $aliases
     * @return self
     */
    public function setAliases(array $aliases);

    /**
     * 获取描述
     *
     * @return string
     */
    public function getDescription();

    /**
     * 设置描述
     *
     * @param string $description
     */
    public function setDescription($description);

    /**
     * 命令是否启用
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * 获取命令容器
     *
     * @return IPool
     */
    public function getPool();

    /**
     * 设置命令容器
     *
     * @param IPool $pool
     */
    public function setPool(IPool $pool = null);


    /**
     * 获取版本号
     *
     * @return string
     */
    public function getVersion();

    /**
     * 获取命令参数
     *
     * @return array
     */
    public function getArguments();

    /**
     * 获取帮助信息
     *
     * @return string
     */
    public function getHelp();

    /**
     * 设置帮助信息
     *
     * @param string $help
     * @return self
     */
    public function setHelp($help);
}