<?php

$i = 0;
while (true) {
    if ($i < 3) {
        echo ++$i . PHP_EOL;
    } else {
        break;
    }
}
