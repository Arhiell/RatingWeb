<?php
include "../config/conexion.php";

$nombre = 'Admin';
$email = 'admin@cine.com';
$password_plana = '123456';
$rol = 'admin';

$hash = password_hash($password_plana, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO Usuario (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $nombre, $email, $hash, $rol);
$stmt->execute();

echo "✅ Admin creado exitosamente.";
?> 