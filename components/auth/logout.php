<?php
session_start();

require '../cookie.php';

if ($_GET['logout'] == true)
{
    unset($_SESSION['user_data']);
    deleteCookie('remember');
}

header('Location: /index.php');