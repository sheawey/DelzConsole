<?php

namespace Delz\Console\Command;

use Delz\Console\Contract\IInput;
use Delz\Console\Contract\IOutput;

/**
 * 命令行hello demo
 *
 * @package Delz\Console\Command
 */
class HelloCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function execute(IInput $input = null, IOutput $output = null)
    {
        $output->writeln("<comment>Hello world.</comment>\tThis a sample");
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('hello')
            ->setDescription("你好世界")
            ->setHelp("this is hello command help.");
    }

}