<?php

namespace Delz\Console\Output;

use Delz\Console\Contract\IOutput;

/**
 * 缓存输出类
 *
 * @package Delz\Console\Output
 */
class Buffer extends Base implements IOutput
{
    /**
     * @var string
     */
    private $buffer = '';

    /**
     * 清空缓存中的内容并且返回内容
     */
    public function fetch()
    {
        $content = $this->buffer;
        $this->buffer = '';
        return $content;
    }

    /**
     * {@inheritdoc}
     */
    protected function doWrite($message, $newline)
    {
        $this->buffer .= $message;

        if ($newline) {
            $this->buffer .= "\n";
        }
    }
}