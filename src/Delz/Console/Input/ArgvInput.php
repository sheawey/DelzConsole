<?php

namespace Delz\Console\Input;

/**
 * 命令行参数
 *
 * @package Delz\Console\Input
 */
class ArgvInput extends Input
{
    /**
     * 获取命令行参数，并将此写入$this->arguments数组
     */
    public function __construct()
    {
        $argv = $_SERVER['argv'];

        //去掉命令行名称，并将命令行名称写入$this->name
        $this->name = array_shift($argv);
        $this->name = basename($this->name);

        while(null !== $a = array_shift($argv)) {
            $arr = explode('=', $a);
            $this->arguments[$arr[0]] = isset($arr[1]) ? $arr[1] : null;
        }
    }
}