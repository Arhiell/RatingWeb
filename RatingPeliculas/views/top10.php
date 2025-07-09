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
  <title>Top 10 Películas</title>
  <link rel="stylesheet" href="../assets/css/top10.css">
</head>
<body>
  <div class="container-top10">
    <h2>🔝 Top 10 Películas Mejor Puntuadas</h2>

    <?php
    $ranking = $conn->query("
      SELECT P.titulo, P.anio, P.duracion, P.clasificacion, AVG(C.puntuacion) AS promedio, COUNT(C.id_pelicula) AS votos
      FROM Pelicula P
      JOIN Calificacion C ON P.id_pelicula = C.id_pelicula
      GROUP BY P.id_pelicula
      ORDER BY promedio DESC
      LIMIT 10
    ");

    $pos = 1;
    while ($row = $ranking->fetch_assoc()) {
      echo "<div class='movie-card'>
        <div class='position-number'>#$pos</div>
        <div class='movie-title'>{$row['titulo']} ({$row['anio']})</div>
        <div class='movie-info'>Duración: {$row['duracion']} • Clasificación: {$row['clasificacion']}</div>
        <div class='movie-rating'>⭐ " . round($row['promedio'], 2) . " ({$row['votos']} votos)</div>
      </div>";
      $pos++;
    }
    ?>
  </div>
</body>
</html>