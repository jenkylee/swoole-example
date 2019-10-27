<?php
/**
 * 进程隔离也是很多新手经常遇到的问题。修改了全局变量的值，为什么不生效，原因就是全局变量在不同的进程，内存空间是隔离的，所以无效。所以使用Swoole开发Server程序需要了解进程隔离问题。
 * 不同的进程中PHP变量不是共享，即使是全局变量，在A进程内修改了它的值，在B进程内是无效的
 * 如果需要在不同的Worker进程内共享数据，可以用Redis、MySQL、文件、Swoole\Table、APCu、shmget等工具实现
 * 不同进程的文件句柄是隔离的，所以在A进程创建的Socket连接或打开的文件，在B进程内是无效，即使是将它的fd发送到B进程也是不可用的
 * 正确的做法是使用Swoole提供的Swoole\Atomic或Swoole\Table数据结构来保存数据。如上述代码可以使用Swoole\Atomic实现ßß
 */
/*$server = new Swoole\Http\Server('0.0.0.0', 9501);

$i = 1;

$server->on('Request', function ($request, $response) {
    global $i;
    $response->end($i++);
});

$server->start();*/

$server = new Swoole\Http\Server('0.0.0.0', 9502);

$atomic = new Swoole\Atomic(1);

$server->on('Request', function ($request, $response) use ($atomic) {
    $response->end($atomic->add(2));
});

$server->start();
