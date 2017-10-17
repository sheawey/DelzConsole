<?php

namespace Delz\Console\Input;

use Delz\Console\Contract\IInput;
use Delz\Console\Exception\InvalidArgumentException;

/**
 * 输入参数类
 *
 * @package Delz\Console\Input
 */
abstract class Input implements IInput
{

    /**
     * 命令名称
     *
     * @var string
     */
    protected $name;

    /**
     * 参数数组
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * 获取命令名称
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstArgument()
    {
        foreach ($this->arguments as $k => $v) {
            if (strpos($k, '-') !== 0 && $v === true) {
                return $k;
            }
        }

        return null;
    }


    /**
     * {@inheritdoc}
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * {@inheritdoc}
     */
    public function getArgument($name)
    {
        if (!$this->hasArgument($name)) {
            throw new InvalidArgumentException(sprintf('The "%s" argument does not exist.', $name));
        }

        return $this->arguments[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasArgument($name)
    {
        if (is_string($name)) {
            return isset($this->arguments[$name]);
        }
        if (is_array($name)) {
            foreach ($name as $item) {
                if (isset($this->arguments[$item])) {
                    return true;
                }
            }
            return false;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function setArgument($name, $value)
    {
        $this->arguments[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return isset($this->arguments[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return isset($this->arguments[$offset]) ? $this->arguments[$offset] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->arguments[$offset] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->arguments[$offset]);
        }
    }


}