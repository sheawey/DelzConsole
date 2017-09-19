<?php

namespace Delz\Console\Command;

use Delz\Console\Contract\IInput;
use Delz\Console\Contract\IOutput;

/**
 * 显示所有命令
 *
 * @package Delz\Console\Command
 */
class ListCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function execute(IInput $input, IOutput $output)
    {
        $output->writeln("Command list:");
        foreach ($this->getPool()->all() as $k => $v) {
            $output->writeln("<comment>$k</comment>\t" . $v->getDescription());
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('list')
            ->setDescription('显示所有命令');
    }
}