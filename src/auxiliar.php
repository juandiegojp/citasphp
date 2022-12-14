<?php

function conectar()
{
    return new \PDO('pgsql:host=localhost,dbname=citasphp', 'citasphp', 'citasphp');
}

function hh($x)
{
    return htmlspecialchars($x ?? '', ENT_QUOTES | ENT_SUBSTITUTE);
}

function obtener_get($par)
{
    return obtener_parametro($par, $_GET);
}

function obtener_post($par)
{
    return obtener_parametro($par, $_POST);
}

function obtener_parametro($par, $array)
{
    return isset($array[$par]) ? trim($array[$par]) : null;
}

function volver()
{
    header('Location: /index.php');
}

function volver_admin()
{
    header("Location: /admin/");
}

function redirigir_login()
{
    header('Location: /login.php');
}