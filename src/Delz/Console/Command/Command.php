<?php

namespace Delz\Console\Command;

use Delz\Console\Input\ArgvInput;
use Delz\Console\Input\ArrayInput;
use Delz\Console\Contract\ICommand;
use Delz\Console\Contract\IInput;
use Delz\Console\Contract\IOutput;
use Delz\Console\Contract\IPool;
use Delz\Console\Exception\InvalidArgumentException;
use Delz\Console\Exception\LogicException;
use Delz\Console\Output\Stream;

/**
 * 命令基类
 *
 * @package Delz\Console\Command
 */
abstract class Command implements ICommand
{

    /**
     * 命令容器
     *
     * @var IPool
     */
    private $pool;

    /**
     * 命令名称
     *
     * @var string
     */
    private $name;

    /**
     * 命令描述
     *
     * @var string
     */
    private $description;

    /**
     * 帮助信息
     *
     * @var string
     */
    private $help;

    /**
     * 命令所有别名
     *
     * @var array
     */
    private $aliases = [];

    /**
     * 命令参数
     *
     * @var array
     */
    private $arguments = [];

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        $this->configure();
    }

    /**
     * {@inheritdoc}
     */
    public function run(IInput $input = null, IOutput $output = null)
    {
        if ($input === null) {
            $input = new ArgvInput();
        }

        if ($output === null) {
            $output = new Stream();
        }

        try {
            //版本号
            if ($input->hasArgument(['-v', '--version'])) {
                $output->writeln($this->getLongVersion());

                return 0;
            }

            //获取帮助
            if ($input->hasArgument(['-h', '--help'])) {
                $output->writeln($this->getDescription());
                $output->writeln("<comment>".$this->getHelp()."</comment>");

                return 0;
            }

            $this->arguments = $input->getArguments();
            $input = new ArrayInput($this->arguments);

            $this->execute($input, $output);

        } catch (\Exception $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->validateName($name);
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addAlias($alias)
    {
        $this->validateName($alias);

        $this->aliases[] = $alias;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAliases()
    {
        return $this->aliases;
    }

    /**
     * {@inheritdoc}
     */
    public function setAliases(array $aliases)
    {
        foreach ($aliases as $alias) {
            $this->addAlias($alias);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getPool()
    {
        return $this->pool;
    }

    /**
     * {@inheritdoc}
     */
    public function setPool(IPool $pool = null)
    {
        $this->pool = $pool;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getVersion()
    {
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
    public function getHelp()
    {
        return $this->help;
    }

    /**
     * {@inheritdoc}
     */
    public function setHelp($help)
    {
        $this->help = $help;

        return $this;
    }


    /**
     * 判断命令名称或者别名是否符合
     *
     * @param string $name 命令名称或者别名
     * @throws InvalidArgumentException
     */
    protected function validateName($name)
    {
        if (!preg_match('/^[a-zA-Z0-9-_:]+$/', $name)) {
            throw new InvalidArgumentException(sprintf('Command name "%s" is invalid.', $name));
        }
    }

    /**
     * 执行命令
     *
     * @param IInput $input
     * @param IOutput $output
     */
    protected function execute(IInput $input, IOutput $output)
    {
        throw new LogicException('You must override the execute() method in the concrete command class.');
    }

    /**
     * 对当前命令参数进行定义
     */
    protected function configure()
    {

    }

    /**
     * 显示版本详细信息
     */
    protected function getLongVersion()
    {
        if ($this->getVersion() !== null) {
            return sprintf('version <comment>%s</comment>', $this->getVersion());
        }

        return 'version: <comment> UNKNOWN</comment>';
    }

}