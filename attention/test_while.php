<?php
/**
 * onReceive事件中执行了死循环，server无法再收到任何客户端请求，必须等待循环结束才能继续处理新的事件。
 */

$serv = new swoole_server("127.0.0.1", 9501);
$serv->set(['worker_num' => 1]);
$serv->on('receive', function ($serv, $fd, $reactorId, $data) {
    $i = 0;
    while(1)
    {
        if ($i > 10)
            break;
        $i ++;
    }
    $serv->send($fd, 'Swoole: '.$i.' '.$reactorId." ".$data);
});
$serv->start();