<?php
session_start();
include "../config/conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$id_pelicula = $_POST['id_pelicula'];
$puntuacion = $_POST['puntuacion'];
$comentario = $_POST['comentario'];

$conn->query("INSERT INTO Calificacion (id_usuario, id_pelicula, puntuacion) VALUES ($id_usuario, $id_pelicula, $puntuacion)");
$conn->query("INSERT INTO Comentario (id_usuario, id_pelicula, contenido) VALUES ($id_usuario, $id_pelicula, '$comentario')");

header("Location: ../views/peliculas.php");
?>