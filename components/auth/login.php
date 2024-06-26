<?php
session_start();

require '../cookie.php';
include '../db/QueryBuilder.php';

$queryBuilder = new QueryBuilder();

$email = $_POST['email'];
$password = $_POST['password'];
$remember = !empty($_POST['remember']) ? $_POST['remember'] : 0;

$warning = [];

if (strlen($email) == 0)
{
    $warning['email']['message'] = 'Заполните поле';
}

if (!filter_var($email,FILTER_VALIDATE_EMAIL))
{
    $warning['name']['message'] = 'Некорректные данные';
    $warning['name']['data'] = $name;
}

if (strlen($password) == 0)
{
    $warning['password']['message'] = 'Заполните поле';
}

if (count($warning) > 0)
{
    $warning['email']['data'] = $email;
    $warning['password']['data'] = $password;
    $_SESSION['warning'] = $warning;
    header('Location: /login.php');
    die;
}

$result = $queryBuilder->findUserByEmail($email);

if ($result == false)
{
    $warning['email']['message'] = 'Неверный адрес e-mail или пароль';
    $warning['password']['message'] = 'Неверный адрес e-mail или пароль';
}

if (count($warning) > 0)
{
    $warning['email']['data'] = $email;
    $warning['password']['data'] = $password;
    $_SESSION['warning'] = $warning;
    header('Location: /login.php');
    die;
}

if (!password_verify($password, $result['password']))
{
    $warning['email']['message'] = 'Неверный адрес e-mail или пароль';
    $warning['password']['message'] = 'Неверный адрес e-mail или пароль';
}

if (count($warning) > 0)
{
    $warning['email']['data'] = $email;
    $warning['password']['data'] = $password;
    $_SESSION['warning'] = $warning;
    header('Location: /login.php');
    die;
}

$user_data = [];
$user_data['id'] = $result['id'];
$user_data['name'] = $result['name'];
$user_data['email'] = $email;
$user_data['password'] = $password;
$image = $queryBuilder->getUser($user_data['id'], 'image');
$user_data['image'] = $image['image'];

$_SESSION['user_data'] = $user_data;

setcookie('remember', $remember, time()+60*60*24*30, '/');

header('Location: /index.php');
die;