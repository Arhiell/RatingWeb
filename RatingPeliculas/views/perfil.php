<?php
session_start();
include "../config/conexion.php";

$id_usuario = $_SESSION['id_usuario'];
$result = $conn->query("SELECT * FROM Vista_ComentariosModerados WHERE usuario = '{$_SESSION['nombre']}'");

echo "<h2>Tus Comentarios</h2>";

while ($row = $result->fetch_assoc()) {
  echo "<p><strong>{$row['pelicula']}</strong>: {$row['comentario']} <em>({$row['fecha']})</em></p>";
}
?>
<a href="peliculas.php">Volver</a>