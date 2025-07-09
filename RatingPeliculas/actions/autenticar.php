<?php
session_start();
include "../config/conexion.php";

$email = $_POST['email'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM Usuario WHERE email='$email'");
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password']) && $user['estado'] == 'activo') {
  $_SESSION['id_usuario'] = $user['id_usuario'];
  $_SESSION['nombre'] = $user['nombre'];
  $_SESSION['rol'] = $user['rol'];
  header("Location: ../views/peliculas.php");
} else {
  echo "Credenciales inválidas o usuario bloqueado.";
}
?>