<?php

require 'cookie.php';
require 'db/QueryBuilder.php';

$queryBuilder = new QueryBuilder();

$id = $_GET['id'];
$state = $_GET['state'];
$delete = $_GET['delete'];

if (!empty($delete) &&
    $delete == 1)
{
    $result = $queryBuilder->deleteComment($id);
}

if (!empty($result) ||
    $result != false)
{
    header('Location: /admin.php');
    die;
}

$queryBuilder = new QueryBuilder();
$result = $queryBuilder->editState($id, $state);

header('Location: /admin.php');
die;