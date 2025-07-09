<?php
include "../config/conexion.php";

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO Usuario (nombre, email, password) VALUES ('$nombre', '$email', '$password')";
if ($conn->query($sql)) {
  header("Location: ../views/login.php");
} else {
  echo "Error al registrar: " . $conn->error;
}
?>