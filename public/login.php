<?php
session_start();

require '../vendor/autoload.php';

$login = obtener_post('id');
$password = obtener_post('password');

$clases_label = '';
$clases_input = '';
$error = false;

if (isset($login, $password)) {
    if ($usuario = \App\Tablas\Usuario::comprobar($login, $password)) {
        // Loguear al usuario
        $_SESSION['login'] = serialize($usuario);
        return $usuario->es_admin() ? volver_admin() : volver();
    } else {
        // Mostrar error de validación
        $error = true;
        $clases_label = "text-red-700 dark:text-red-500";
        $clases_input = "bg-red-50 border-red-500 text-red-900 placeholder-red-700 focus:ring-red-500 focus:border-red-500 dark:bg-red-100 dark:border-red-400";
    }
}
