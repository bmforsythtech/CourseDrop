<?php

if ($_SESSION['instructor'] != 1) {
    $_SESSION['errors'][] = 'Must be an instructor';
    header('Location: index.php');
    die();
}