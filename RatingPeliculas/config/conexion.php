<?php
$host = "localhost";
$usuario = "root";
$password = ""; // Cambialo si tenés otro
$base = "RatingPeliculasBDD";

$conn = new mysqli($host, $usuario, $password, $base);

if ($conn->connect_error) {
  die("Error de conexión: " . $conn->connect_error);
}
?>