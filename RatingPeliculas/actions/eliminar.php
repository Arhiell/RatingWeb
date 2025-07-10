<?php
session_start();
include "../config/conexion.php";

if ($_SESSION['rol'] !== 'admin') {
  echo "<script>alert('Acceso denegado'); window.location.href='../views/peliculas.php';</script>";
  exit();
}

$id = $_GET['id'];
$conn->query("DELETE FROM Pelicula WHERE id_pelicula = $id");

echo "<script>alert('Película eliminada'); window.location.href='../views/admin_panel.php';</script>";
?>