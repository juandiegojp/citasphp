<?php
session_start();

require '../vendor/autoload.php';

$fecha = obtener_post('fecha');
$hora = obtener_post('horas');
$usuario = \App\Tablas\Usuario::logueado()->id;

$pdo = conectar();
$sent = $pdo->prepare('INSERT INTO citas (fecha, hora, id_usuario)
                        VALUES (:fecha, :horas, :usuario)');
$sent->execute([':usuario' => $usuario, ':fecha' => $fecha, ':horas' => $hora]);

return volver();