<?php

namespace Delz\Console\Exception;

use Delz\Console\Contract\IException;

/**
 * 命令没有找到异常
 *
 * @package Pitaya\Component\Console\Exception
 */
class CommandNotFoundException extends \InvalidArgumentException implements IException
{

}