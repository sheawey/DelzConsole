<?php

namespace Delz\Console\Exception;

use Delz\Console\Contract\IException;

/**
 * 非法参数异常
 *
 * @package Delz\Console\Exception
 */
class InvalidArgumentException extends \InvalidArgumentException implements IException
{

}