<?php
session_start();
include "../config/conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$id_pelicula = $_POST['id_pelicula'];
$puntuacion = $_POST['puntuacion'];
$comentario = $_POST['comentario'];

// Verifica si ya calificó esa película
$verifica = $conn->query("SELECT * FROM Calificacion WHERE id_usuario = $id_usuario AND id_pelicula = $id_pelicula");

if ($verifica->num_rows > 0) {
  echo "<script>
    alert('Ya calificaste esta película. No se puede volver a votar.');
    window.location.href = '../views/peliculas.php';
  </script>";
  exit();
}

// Inserta nueva calificación
$conn->query("INSERT INTO Calificacion (id_usuario, id_pelicula, puntuacion, comentario)
VALUES ($id_usuario, $id_pelicula, $puntuacion, '$comentario')");

echo "<script>
  alert('¡Gracias por tu calificación!');
  window.location.href = '../views/peliculas.php';
</script>";
?>