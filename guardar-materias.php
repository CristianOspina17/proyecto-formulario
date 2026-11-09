<?php
session_start();

$conexion = new mysqli("localhost", "root", "", "registro","3307");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


if (!isset($_SESSION['usuario_id'])) {
    die("Usuario no autenticado");
}

$usuario_id = $_SESSION['usuario_id'];


$nombres = $_POST['nombre'] ?? [];
$notas = $_POST['nota'] ?? [];
$porcentajes = $_POST['porcentaje'] ?? [];


if (empty($nombres)) {
    die("Debes agregar al menos una materia");
}

$sql = "INSERT INTO materias (usuario_id, nombre, nota, porcentaje) VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);

for ($i = 0; $i < count($nombres); $i++) {

    $nombre = $nombres[$i];
    $nota = $notas[$i];
    $porcentaje = $porcentajes[$i];

    $stmt->bind_param("isdi", $usuario_id, $nombre, $nota, $porcentaje);
    $stmt->execute();
}

$stmt->close();
$conexion->close();

echo "Materias guardadas correctamente";
?>
