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
  <title>Películas</title>
  <link rel="stylesheet" href="../assets/css/peliculas.css">
</head>
<body>
  <div class="container-peliculas">
    <h2>🎥 Películas disponibles</h2>
    <p>Bienvenido, <?= $_SESSION['nombre']; ?> | <a href="../actions/logout.php">Cerrar sesión</a></p>

    <?php
    $peliculas = $conn->query("SELECT * FROM Pelicula");

    while ($p = $peliculas->fetch_assoc()) {
      echo "<div class='pelicula-card'>
        <div class='titulo-pelicula'>{$p['titulo']} ({$p['anio']})</div>
        <div class='info-peli'>Director: {$p['director']} </div>
        <div class ='info-peli'> Descripcion: {$p['descripcion']}</div>
        <div class ='info-peli'> Clasificacion: {$p['clasificacion']}</div>

        <form action='../actions/calificar.php' method='POST'>
          <input type='hidden' name='id_pelicula' value='{$p['id_pelicula']}'>
          <label>Puntaje:</label>
          <input type='number' name='puntuacion' min='1' max='10' required>
          <label>Comentario:</label>
          <textarea name='comentario'></textarea>
          <button type='submit'>Enviar</button>
        </form>
      </div>";
    }
    ?>
  </div>
  <div class="extras">
  <a href="comentarios.php" class="extra-btn">🗨️ Ver Comentarios de Usuarios</a>
  <a href="top10.php" class="extra-btn">🔝 Ver Top 10 de Películas Valoradas</a>
</div>
</body>
</html>