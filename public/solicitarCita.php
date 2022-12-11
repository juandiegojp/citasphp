<?php 

require '../vendor/autoload.php';

$fecha = obtener_post('fecha');
$hora = obtener_post('hora');
$usuario = \App\Tablas\Usuario::logueado()->id;

$pdo = conectar();
$sent = $pdo->prepare('INSERT INTO citas (fecha, hora, id_usuario)
                        VALUES (:fecha, :hora, :usuario)');
$sent->execute([':usuario' => $usuario, ':fecha' => $fecha, ':hora' => $hora]);

return volver();