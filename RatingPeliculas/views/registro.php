<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registro</title>
  <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
  <h2>Registro de Usuario</h2>
  <form action="../actions/registrar.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Registrarse</button>
  </form>
  <p>¿Ya tenés cuenta? <a href="login.php">Iniciar sesión</a></p>
</body>
</html>