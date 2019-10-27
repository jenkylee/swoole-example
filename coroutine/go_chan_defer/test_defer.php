<?php
Swoole\Runtime::enableCoroutine();

go(function() {
   echo "go start\n";
   defer(function() {
       echo "defer1\n";
   });
   echo "go inner\n";
   defer(function() {
      echo "defer2\n";
   });
   echo "go end\n";
});
