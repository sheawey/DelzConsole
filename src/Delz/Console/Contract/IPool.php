<?php

namespace Delz\Console\Contract;

/**
 * 命令容器接口类
 *
 * @package Delz\Console\Contract
 */
interface IPool
{
    /**
     * 添加命令对象到容器
     *
     * @param ICommand $command
     */
    public function add(ICommand $command);

    /**
     * 从容器中获取命令对象
     *
     * @param string $name
     * @return ICommand
     */
    public function get($name);

    /**
     * 根据名称判断容器中是否存在命令对象
     *
     * @param string $name
     * @return bool
     */
    public function has($name);

    /**
     * 获取所有命令
     *
     * @return array
     */
    public function all();
}