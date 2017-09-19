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
     * @param array|null $argv
     */
    public function __construct(array $argv = null)
    {
        if(null === $argv) {
            $argv = $_SERVER['argv'];
        }

        //去掉命令行名称
        array_shift($argv);

        while(null !== $a = array_shift($argv)) {
            $arr = explode('=', $a);
            $this->arguments[$arr[0]] = isset($arr[1]) ? $arr[1] : $arr[0];
        }
    }
}