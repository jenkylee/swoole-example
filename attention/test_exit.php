<?php
/**
 * 在swoole程序中禁止使用exit/die，如果PHP代码中有exit/die，当前工作的Worker进程、Task进程、User进程、以及swoole_process进程会立即退出。
 * 使用exit/die后Worker进程会因为异常退出, 被master进程再次拉起, 最终造成进程不断退出又不断启动和产生大量警报日志.
 *
 * 建议使用try/catch的方式替换exit/die，实现中断执行跳出PHP函数调用栈。
 */

function swoole_exit($msg)
{
    if (EVN == 'php') {
        exit($msg);
    } else {
        throw new Swoole\ExitException($msg);
    }
}
