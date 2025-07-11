<?php
session_start();
include "../config/conexion.php";

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM Usuario WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
  $usuario = $resultado->fetch_assoc();

  if (password_verify($password, $usuario['password'])) {
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['rol'] = $usuario['rol'];

    // Redirige según rol
    if ($_SESSION['rol'] === 'admin') {
      header("Location: ../views/admin.php");
    } else {
      header("Location: ../views/peliculas.php");
    }
    exit();
  } else {
    echo "<script>alert('Contraseña incorrecta'); window.location.href='../views/login.php';</script>";
  }
} else {
  echo "<script>alert('Usuario no encontrado'); window.location.href='../views/login.php';</script>";
}
?>