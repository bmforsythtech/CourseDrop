<?php

require_once('config.php');
require_once(DIR_INCLUDES . 'init.php');

if (strtotime($config['open'] . ' ' . $config['openTime']) > time() ||
    strtotime($config['close'] . ' ' . $config['closeTime']) < time())
{
    include(DIR_VIEWS . 'header.php');
    include(DIR_VIEWS . 'form.closed.php');
    include(DIR_VIEWS . 'footer.php');
} else {
    header('Location: form.php');
    exit();
}