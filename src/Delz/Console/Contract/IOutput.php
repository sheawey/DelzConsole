<?php

namespace Delz\Console\Contract;

/**
 * 命令行输出接口类
 *
 * @package Delz\Console\Contract
 */
interface IOutput
{
    /**
     * 消息输出模式：标准输出
     */
    const OUTPUT_NORMAL = 1;

    /**
     * 消息输出模式：原始消息输出
     */
    const OUTPUT_RAW = 2;

    /**
     * 消息输出模式：去除消息中的标记
     */
    const OUTPUT_PLAIN = 4;

    /**
     * 输出信息冗余度阈值：不输出任何信息
     */
    const VERBOSITY_QUIET = 1;

    /**
     * 输出信息冗余度阈值：默认
     */
    const VERBOSITY_NORMAL = 2;

    /**
     * 输出信息冗余度阈值：比IOutput::VERBOSITY_NORMAL更详细的介绍
     */
    const VERBOSITY_VERBOSE = 4;

    /**
     * 输出信息冗余度阈值：比IOutput::VERBOSITY_VERBOSE更详细的介绍
     */
    const VERBOSITY_VERY_VERBOSE = 8;

    /**
     * 输出信息冗余度阈值：debug信息
     */
    const VERBOSITY_DEBUG = 16;

    /**
     * 在命令行输出一条消息
     *
     * @param string|array $messages 要输出的消息，可以是字符串，也可以是数组
     * @param bool $newline 输出信息后面是否添加一个空行
     * @param int $type 消息输出模式，使用位掩码（BitMask）
     */
    public function write($messages, $newline = false, $type = IOutput::OUTPUT_NORMAL);

    /**
     * 在命令行输出一条消息，消息后自动加上一个空行
     *
     * @param string|array $messages 要输出的消息，可以是字符串，也可以是数组
     * @param int $type 消息输出模式，使用位掩码（BitMask）
     */
    public function writeln($messages, $type = IOutput::OUTPUT_NORMAL);

    /**
     * 获取信息冗余度阈值
     *
     * @return int
     */
    public function getVerbosity();

    /**
     * 设置信息冗余度阈值
     *
     * @param int $level
     */
    public function setVerbosity($level);

    /**
     * 判断信息冗余度阈值是否是IOutput::VERBOSITY_NORMAL
     *
     * @return bool
     */
    public function isQuiet();

    /**
     * 判断信息冗余度阈值是否是IOutput::VERBOSITY_VERBOSE以及更高的
     *
     * @return bool
     */
    public function isVerbose();

    /**
     * 判断信息冗余度阈值是否是IOutput::VERBOSITY_VERY_VERBOSE以及更高的
     *
     * @return bool
     */
    public function isVeryVerbose();

    /**
     * 判断信息冗余度阈值是否是IOutput::VERBOSITY_DEBUG以及更高的
     *
     * @return bool
     */
    public function isDebug();

    /**
     * 获取输出格式对象
     *
     * @return IFormatter
     */
    public function getFormatter();

    /**
     * 设置叔叔格式对象
     *
     * @param IFormatter $formatter
     */
    public function setFormatter(IFormatter $formatter);

    /**
     * 设置是否装饰输出
     *
     * 指输出前景色，背景色以及各种控制选项，某些命令行不支持
     *
     * 直接调用IFormatter::setDecorated($decorated)方法设置，IFormatter可以从本接口方法getFormatter()获取
     *
     * @param bool $decorated
     */
    public function setDecorated($decorated);

    /**
     * 是否装饰输出
     *
     * 指输出前景色，背景色以及各种控制选项，某些命令行不支持
     *
     * 直接调用IFormatter::isDecorated($decorated)方法设置，IFormatter可以从本接口方法getFormatter()获取
     *
     * @return bool
     */
    public function isDecorated();

}