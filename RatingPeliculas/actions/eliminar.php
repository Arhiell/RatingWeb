<?php
session_start();
include "../config/conexion.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
  echo "<script>alert('No autorizado'); window.location.href='../views/peliculas.php';</script>";
  exit();
}

$id = $_GET['id'] ?? 0;

// Primero eliminar las relaciones en pelicula_genero
$conn->query("DELETE FROM pelicula_genero WHERE id_pelicula = $id");

// Ahora eliminar la película
$conn->query("DELETE FROM Pelicula WHERE id_pelicula = $id");

echo "<script>
  alert('Película eliminada');
  window.location.href='../views/admin.php';
</script>";