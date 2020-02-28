<?php
session_start();

require 'cookie.php';
require 'db/QueryBuilder.php';

$queryBuilder = new QueryBuilder();

$name = $_SESSION['user_data']['name'];
$image = $_SESSION['user_data']['image'] ? $_SESSION['user_data']['image'] : '';
$date = date('Y-m-d');
$message = $_POST['message'];

$warning = [];

if (strlen($message) == 0)
{
    $warning['message']['message'] = 'Заполните поле';
}

if (count($warning) > 0)
{
    $_SESSION['warning'] = $warning;
    header('Location: /index.php');
    die;
}

if (!filter_var($message, FILTER_SANITIZE_STRING))
{
    $warning['message']['message'] = 'Ошибка фильтрации';
}

if (count($warning) > 0)
{
    $warning['message']['data'] = $message;
    $_SESSION['warning'] = $warning;
    header('Location: /index.php');
    die;
}

$result = $queryBuilder->addComment($name, $image, $date, $message);

if (!$result)
{
    $warning['page']['message'] = 'Ошибка добавления коментария';
}

if (count($warning) > 0)
{
    $_SESSION['warning'] = $warning;
    header('Location: /index.php');
    die;
}

$_SESSION['new_comment'] = true;

header('Location: /index.php');