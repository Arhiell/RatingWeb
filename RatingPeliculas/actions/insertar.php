<?php
session_start();
include "../config/conexion.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
  echo "<script>alert('No autorizado'); window.location.href='../views/peliculas.php';</script>";
  exit();
}

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$anio = $_POST['anio'];
$director = $_POST['director'];
$clasificacion = $_POST['clasificacion'];
$duracion = $_POST['duracion'];
$id_genero = $_POST['id_genero']; // seleccionado en el formulario

// Insertar película
$stmt = $conn->prepare("INSERT INTO Pelicula (titulo, descripcion, anio, director, clasificacion, duracion) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssisss", $titulo, $descripcion, $anio, $director, $clasificacion, $duracion);
$stmt->execute();

$id_pelicula = $conn->insert_id;

// Insertar género asociado (relación en tabla intermedia)
$conn->query("INSERT INTO Pelicula_Genero (id_pelicula, id_genero) VALUES ($id_pelicula, $id_genero)");

echo "<script>
  alert('🎉 Película agregada exitosamente');
  window.location.href='../views/admin.php';
</script>";
?>