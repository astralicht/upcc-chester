<?php

session_start();

foreach ($_COOKIE as $key => $value) {
    echo nl2br("$key >> $value\r\n");
}