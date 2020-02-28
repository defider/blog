<?php
session_start();

require 'cookie.php';
require 'db/QueryBuilder.php';

$id = $_SESSION['user_data']['id'];
$old_password = trim($_POST['old_password']);
$password = trim($_POST['password']);
$password_confirmation = trim($_POST['password_confirmation']);

$warning = [];

if (empty($old_password) ||
    strlen($old_password) == 0)
{
    $warning['old_password']['message'] = 'Заполните поле';
}

if (empty($password) ||
    strlen($password) == 0)
{
    $warning['password']['message'] = 'Заполните поле';
}

if (empty($password_confirmation) ||
    strlen($password_confirmation) == 0)
{
    $warning['password_confirmation']['message'] = 'Заполните поле';
}

if (count($warning) > 0)
{
    $warning['old_password']['data'] = $old_password;
    $warning['password']['data'] = $password;
    $warning['password_confirmation']['data'] = $password_confirmation;

    $_SESSION['warning'] = $warning;
    header('Location: /profile.php');
    die;
}

$queryBuilder = new QueryBuilder();
$hash = $queryBuilder->getUser($id, 'password');

if (!password_verify($old_password, $hash['password']))
{
    $warning['old_password']['message'] = 'Неправильно набран пароль';
}

if (count($warning) > 0)
{
    $warning['old_password']['data'] = $old_password;
    $warning['password']['data'] = $password;
    $warning['password_confirmation']['data'] = $password_confirmation;

    $_SESSION['warning'] = $warning;
    header('Location: /profile.php');
    die;
}

if ($password != $password_confirmation ||
    strlen($password) != strlen($password_confirmation))
{
    $warning['password']['message'] = 'Пароли не совпадают';
    $warning['password_confirmation']['message'] = 'Пароли не совпадают';
}

if (count($warning) > 0)
{
    $warning['old_password']['data'] = $old_password;
    $warning['password']['data'] = $password;
    $warning['password_confirmation']['data'] = $password_confirmation;

    $_SESSION['warning'] = $warning;
    header('Location: /profile.php');
    die;
}

$new_password = password_hash($password, PASSWORD_DEFAULT);

$result = $queryBuilder->editPassword($id, $new_password);

if (!$result)
{
    echo 'Ошибка обновления пароля';
    die;
}

$_SESSION['user_data']['password'] = $password;
$_SESSION['new_password'] = true;

header('Location: /profile.php');