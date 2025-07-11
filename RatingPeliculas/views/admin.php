<?php
session_start();
include "../config/conexion.php";

if (!isset($_SESSION['id_usuario']) || $_SESSION['rol'] !== 'admin') {
  echo "<script>alert('Acceso restringido'); window.location.href='peliculas.php';</script>";
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Panel Admin</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="admin-container">
    <h2>🎬 Panel de Administración</h2>
    <p>Bienvenido, <?= $_SESSION['nombre']; ?> | <a href="../actions/logout.php">Cerrar sesión</a></p>

    <form action="../actions/insertar.php" method="POST">
      <input type="text" name="titulo" placeholder="Título" required>
      <textarea name="descripcion" placeholder="Descripción" required></textarea>
      <input type="number" name="anio" placeholder="Año" required>
      <input type="text" name="director" placeholder="Director" required>

      <!-- Clasificación como ENUM -->
      <label for="clasificacion">Clasificación</label>
      <select name="clasificacion" required>
        <option value="ATP">Apta para todo público (ATP)</option>
        <option value="ATPR">ATP con reservas (ATPR)</option>
        <option value="P-13">Mayores de 13 años (P-13)</option>
        <option value="P-16">Mayores de 16 años (P-16)</option>
        <option value="P-18">Mayores de 18 años (P-18)</option>
      </select>

      <input type="text" name="duracion" placeholder="Duración (ej: 2h 10m)">

      <label for="id_genero">Género</label>
      <select name="id_genero" required>
        <?php
        $generos = $conn->query("SELECT * FROM Genero");
        while ($g = $generos->fetch_assoc()) {
          echo "<option value='{$g['id_genero']}'>{$g['nombre']}</option>";
        }
        ?>
      </select>

      <button type="submit">Agregar Película</button>
    </form>

    <hr>
    <h3>📽 Películas Existentes</h3>
    <?php
    $peliculas = $conn->query("SELECT * FROM Pelicula");
    while ($p = $peliculas->fetch_assoc()) {
      echo "<div class='admin-card'>
        <strong>{$p['titulo']} ({$p['anio']})</strong>
        <a class='btn-eliminar' href='../actions/eliminar.php?id={$p['id_pelicula']}'>❌ Eliminar</a>
      </div>";
    }
    ?>
  </div>
</body>
</html>