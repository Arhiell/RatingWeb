<?php
session_start();
include "../config/conexion.php";

if (!isset($_SESSION['id_usuario'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Comentarios de Usuarios</title>
  <link rel="stylesheet" href="../assets/css/comentarios.css">
</head>
<body>
  <div class="container-comentarios">
    <h2>🗨️ Comentarios y Calificaciones de Todos los Usuarios</h2>

    <?php
    $consulta = $conn->query("
    SELECT U.nombre, P.titulo, CA.puntuacion, CO.contenido
FROM Calificacion CA
JOIN Comentario CO ON CA.id_usuario = CO.id_usuario AND CA.id_pelicula = CO.id_pelicula
JOIN Usuario U ON CA.id_usuario = U.id_usuario
JOIN Pelicula P ON CA.id_pelicula = P.id_pelicula
ORDER BY CA.fecha DESC;
    ");

    while ($row = $consulta->fetch_assoc()) {
      echo "<div class='comentario-card'>
        <strong>{$row['nombre']}</strong> calificó <em>{$row['titulo']}</em> con <span class='estrella'>⭐ {$row['puntuacion']}</span>
        <p>{$row['contenido']}</p>
      </div>";
    }
    ?>
  </div>
</body>
</html>