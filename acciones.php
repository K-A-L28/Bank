<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(["mensaje" => "No autenticado", "saldo" => 0]);
    exit;
}

$conexion = new mysqli("localhost", "root", "", "banco");
$id = $_SESSION['usuario_id'];
$tipo = $_POST['tipo'];
$monto = isset($_POST['monto']) ? floatval($_POST['monto']) : 0;

$res = $conexion->query("SELECT saldo FROM usuarios WHERE id = $id");
$row = $res->fetch_assoc();
$saldo_actual = $row['saldo'];

switch ($tipo) {
  case 'depositar':
    if ($monto > 0) {
      $nuevo = $saldo_actual + $monto;
      $conexion->query("UPDATE usuarios SET saldo = $nuevo WHERE id = $id");
      echo json_encode(["mensaje" => "Depósito exitoso", "saldo" => number_format($nuevo, 2)]);
    } else {
      echo json_encode(["mensaje" => "Monto inválido", "saldo" => number_format($saldo_actual, 2)]);
    }
    break;

  case 'retirar':
    if ($monto > 0 && $saldo_actual >= $monto) {
      $nuevo = $saldo_actual - $monto;
      $conexion->query("UPDATE usuarios SET saldo = $nuevo WHERE id = $id");
      echo json_encode(["mensaje" => "Retiro exitoso", "saldo" => number_format($nuevo, 2)]);
    } else {
      echo json_encode(["mensaje" => "Fondos insuficientes o monto inválido", "saldo" => number_format($saldo_actual, 2)]);
    }
    break;

  case 'consultar':
    echo json_encode(["mensaje" => "Consulta realizada", "saldo" => number_format($saldo_actual, 2)]);
    break;

  default:
    echo json_encode(["mensaje" => "Acción no válida", "saldo" => number_format($saldo_actual, 2)]);
}
