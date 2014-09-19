<?php

if ($_SESSION['admin'] != 1) {
    $_SESSION['errors'][] = 'Must be admin';
    header('Location: index.php');
    die();
}