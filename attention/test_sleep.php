<?php
/**
 * onReceive事件中执行了sleep函数，server在100秒内无法再收到任何客户端请求。
 *
 */
$serv = new swoole_server('0.0.0.0', 9501);
$serv->set(['timeout' => 1]);
$serv->on('receive', function($serv, $fd, $from_id, $data) {
    sleep(100);
    $serv->send($fd, 'Swoole: '.$data);
});
$serv->start();