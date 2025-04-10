<?php
session_start();
$messege = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "banco");

    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conexion->prepare("SELECT id, contrasena FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hash);
        $stmt->fetch();
        if (password_verify($contrasena, $hash)) {
            $_SESSION['usuario_id'] = $id;
            header("Location: index.php");
            exit;
        } else {
            $messege= "Contraseña incorrecta.";
        }
    } else {
        $messege=  "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form class="form-login" method="POST">
    <h2>Iniciar sesión</h2>
    <input class="input-register" type="email" name="email" placeholder="Email" required><br>
    <input class="input-register" type="password" name="contrasena" placeholder="Contraseña" required><br>
    <button class="button-register" type="submit">Iniciar sesión</button>
    <a class="link-register" href="registro.php">No estas registrado?</a>
    <p class="message"><?php echo $messege; ?></p>
    </form>
</body>
</html>


