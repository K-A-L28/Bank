<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "banco");
$id = $_SESSION['usuario_id'];

$res = $conexion->query("SELECT nombre, saldo FROM usuarios WHERE id = $id");
$usuario = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Banco</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <h1>Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h1>
    <div class="saldo" id="saldo">Saldo actual: $<?php echo number_format($usuario['saldo'], 2); ?></div>

    <input type="number" id="monto" placeholder="Ingrese monto" />
    <div class="botones">
      <button onclick="accion('depositar')">Depositar</button>
      <button onclick="accion('retirar')">Retirar</button>
      <button onclick="accion('consultar')">Consultar</button>
      <a href="logout.php"><button style="background:#e74c3c">Cerrar sesión</button></a>
    </div>
    <p id="mensaje"></p>
  </div>

  <script>
    function accion(tipo) {
      const monto = document.getElementById('monto').value;
      fetch('acciones.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `tipo=${tipo}&monto=${monto}`
      })
        .then(res => res.json())
        .then(data => {
          document.getElementById('saldo').innerText = `Saldo actual: $${data.saldo}`;
          document.getElementById('mensaje').innerText = data.mensaje;
        });
    }
  </script>
</body>
</html>
