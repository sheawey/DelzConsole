<?php

namespace Delz\Console\Exception;

use Delz\Console\Contract\IException;

/**
 * 命令行运行异常
 *
 * @package Delz\Console\Exception
 */
class RuntimeException extends \RuntimeException implements IException
{

}