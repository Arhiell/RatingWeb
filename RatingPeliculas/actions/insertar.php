<?php
session_start();
include "../config/conexion.php";

if ($_SESSION['rol'] !== 'admin') {
  echo "<script>alert('Acceso denegado'); window.location.href='../views/peliculas.php';</script>";
  exit();
}

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$anio = $_POST['anio'];
$director = $_POST['director'];
$clasificacion = $_POST['clasificacion'];
$duracion = $_POST['duracion'];
$id_genero = $_POST['id_genero'];
$imagen = $_POST['imagen'];

$stmt = $conn->prepare("
  INSERT INTO Pelicula (titulo, descripcion, anio, id_genero, director, clasificacion, duracion, imagen)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("ssiissss", $titulo, $descripcion, $anio, $id_genero, $director, $clasificacion, $duracion, $imagen);
$stmt->execute();

echo "<script>alert('Película agregada exitosamente'); window.location.href='../views/admin_panel.php';</script>";
?>