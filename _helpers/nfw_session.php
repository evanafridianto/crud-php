<?php

use Josantonius\Session\Session;

$session = new Session();
if ($session::init()) {
    $session::init();
}
$session::setPrefix('crud-php');
