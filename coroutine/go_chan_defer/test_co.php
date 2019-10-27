<?php
\Swoole\Runtime::enableCoroutine();

go(function() {
   sleep(1);
   echo "a";
});

go(function() {
    sleep(2);
    echo "b";
});
