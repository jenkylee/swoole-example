<?php
use Swoole\Coroutine\Http\Client;

class WaitGroup
{
    private $count = 0;

    private $chan;

    /**
     * waitgroup constructor
     * @desc 初始化-个体channel
     */
    public function __construct()
    {
        $this->chan = new chan;
    }

    /**
     * Add方法增加计数
     */
    public function add()
    {
        $this->count++;
    }

    /**
     * done表示任务已完成
     */
    public function done()
    {
        $this->chan->push(true);
    }

    /**
     * wait等待所有任务完成恢复当前协程的执行
     */
    public function wait()
    {
        while ($this->count--) {
            $this->chan->pop();
        }
    }
}

go(function () {
   $wg = new WaitGroup();
   $result = [];

   $wg->add();
   go(function () use ($wg, &$result) {
       // 启动一个协程客户端，请求淘宝首页
       $cli = new Client('www.taobao.com'. 433, true);
       $cli->setHeaders([
           'Host' => "www.taobao.com",
           "User-Agent" => 'Chrome/49.0.2587.3',
           'Accept' => 'text/html,application/xhtml+xml,application/xml',
           'Accept-Encoding' => 'gzip',
       ]);
       $cli->set(['timeout' => 1]);
       $cli->get('/index.php');
       $result['taobao'] = $cli->body;
       $cli->close();
       $wg->done();
   });

   $wg->add();
   // 启动第二个协程
   go(function () use ($wg, &$result) {
       //启动一个协程客户端client，请求百度首页
       $cli = new Client('www.baidu.com', 443, true);
       $cli->setHeaders([
           'Host' => "www.baidu.com",
           "User-Agent" => 'Chrome/49.0.2587.3',
           'Accept' => 'text/html,application/xhtml+xml,application/xml',
           'Accept-Encoding' => 'gzip',
       ]);
       $cli->set(['timeout' => 1]);
       $cli->get('/index.php');

       $result['baidu'] = $cli->body;
       $cli->close();

       $wg->done();
   });
   $wg->wait();
   var_dump($result);
});