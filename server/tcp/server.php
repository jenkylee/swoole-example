<?php
/**
 * 在命令行下运行server.php程序，启动成功后可以使用 netstat 工具看到，已经在监听9501端口。这时就可以使用telnet/netcat工具连接服务器。
 * telnet 127.0.0.1 9501
 * hello
 * Server: hello
 */
//创建Server对象，监听 127.0.0.1:9501端口
$serv = new swoole_server("127.0.0.1", 9501);

//监听连接进入事件
$serv->on('connect', function ($serv, $fd) {
    echo "Client: Connect.\n";
});

//监听数据接收事件
$serv->on('receive', function ($serv, $fd, $from_id, $data) {
    $serv->send($fd, "Server: ".$data);
});

//监听连接关闭事件
$serv->on('close', function ($serv, $fd) {
    echo "Client: Close.\n";
});

//启动服务器
$serv->start();