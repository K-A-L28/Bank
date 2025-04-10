<?php
$messege = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "banco");

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, contrasena) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nombre, $email, $contrasena);

    if ($stmt->execute()) {
        $messege= "Registro exitoso. <a class='link-register' href='login.php'>Iniciar sesión</a>";
    } else {
        $messege= "Error: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regirtro usuario</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form class="form-register"  method="POST">
    <h2>Registrarse</h2>
    <input  class="input-register" type="text" name="nombre" placeholder="Nombre" required><br>
    <input class="input-register" type="email" name="email" placeholder="Email" required><br>
    <input class="input-register" type="password" name="contrasena" placeholder="Contraseña" required><br>
    <button class="button-register" type="submit">Registrarse</button>
    <php class="message"><?php echo $messege; ?></p>
    </form>
</body>
</html>

