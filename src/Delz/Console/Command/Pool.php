<?php

namespace Delz\Console\Command;

use Delz\Console\Contract\ICommand;
use Delz\Console\Contract\IPool;
use Delz\Console\Exception\CommandNotFoundException;

/**
 * 命令容器
 *
 * @package Delz\Console\Command
 */
class Pool implements IPool
{
    /**
     * 命令容器
     *
     * @var array
     */
    private $commands = [];

    /**
     * {@inheritdoc}
     */
    public function add(ICommand $command)
    {
        if(!$command->isEnabled()) {
            $command->setPool(null);
            return false;
        }
        $command->setPool($this);
        $this->commands[$command->getName()] = $command;
        foreach($command->getAliases() as $alias) {
            $this->commands[$alias] = $command;
        }

        return $command;
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        if(!$this->has($name)) {
            throw new CommandNotFoundException(sprintf('The command "%s" does not exist.', $name));
        }

        return $this->commands[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return isset($this->commands[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->commands;
    }


}