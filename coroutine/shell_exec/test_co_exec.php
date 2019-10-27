<?php

$c = 10;

while($c--) {
    go(function() {
       co::exec("sleep 5");
    });
}