<?php

namespace Delz\Console\Input;

/**
 * 数组参数
 *
 * @package Delz\Console\Input
 */
class ArrayInput extends Input
{
    /**
     * @param array $arguments
     */
    public function __construct(array $arguments = [])
    {
        $this->arguments = $arguments;
    }
}