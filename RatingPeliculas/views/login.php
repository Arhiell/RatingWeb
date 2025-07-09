<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
  <h2>Inicio de Sesión</h2>
  <form action="../actions/autenticar.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Ingresar</button>
  </form>
  <p>¿No tenés cuenta? <a href="registro.php">Registrarse</a></p>
</body>
</html>