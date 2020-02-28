<?php
session_start();

require '../cookie.php';
require '../db/QueryBuilder.php';

$queryBuilder = new QueryBuilder();

$name = addcslashes(trim($_POST['name']), "'");
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$password_confirmation = trim($_POST['password_confirmation']);

$warning = [];

if (empty($name) ||
    strlen($name) == 0)
{
    $warning['name']['message'] = 'Заполните поле';
}

if (empty($email) ||
    strlen($email) == 0)
{
    $warning['email']['message'] = 'Заполните поле';
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
    $warning['name']['data'] = $name;
    $warning['email']['data'] = $email;
    $warning['password']['data'] = $password;
    $warning['password_confirmation']['data'] = $password_confirmation;

    $_SESSION['warning'] = $warning;
    header('Location: /register.php');
    die;
}

if (!filter_var($name,FILTER_SANITIZE_STRING))
{
    $warning['name']['message'] = 'Некорректные данные';
    $warning['name']['data'] = $name;
}

if (!filter_var($email,FILTER_VALIDATE_EMAIL))
{
    $warning['email']['message'] = 'Некорректные данные';
    $warning['email']['data'] = $email;
}

if (count($warning) > 0)
{
    $warning['name']['data'] = $name;
    $warning['email']['data'] = $email;
    $warning['password']['data'] = $password;
    $warning['password_confirmation']['data'] = $password_confirmation;

    $_SESSION['warning'] = $warning;
    header('Location: /register.php');
    die;
}

$result = $queryBuilder->checkDublicateEmail($email);

if ($result != false ||
    strlen($result) > 0)
{
    $warning['email']['message'] = 'Данный e-mail уже занят';
    $warning['email']['data'] = $_POST['email'];
}

if ($password != $password_confirmation ||
    strlen($password) != strlen($password_confirmation))
{
    $warning['password']['message'] = 'Пароли не совпадают';
    $warning['password_confirmation']['message'] = 'Пароли не совпадают';
}

if (strlen($password) < 6)
{
    $warning['password']['message'] = 'Пароль должен содержать не менее 6-и символов';
}

if (strlen($password_confirmation) < 6)
{
    $warning['password_confirmation']['message'] = 'Пароль должен содержать не менее 6-и символов';
}

if (count($warning) > 0)
{
    $warning['name']['data'] = $name;
    $warning['email']['data'] = $email;
    $warning['password']['data'] = $password;
    $warning['password_confirmation']['data'] = $password_confirmation;

    $_SESSION['warning'] = $warning;
    header('Location: /register.php');
    die;
}

$password = password_hash($password, PASSWORD_DEFAULT);
$queryBuilder->addUser($name, $email, $password);

$_SESSION['new_user'] = true;

header('Location: /register.php');
die;