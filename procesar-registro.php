<?php

session_start();

$conexion = new mysqli("localhost", "root", "", "registro", "3307");

if ($conexion->connect_error) {
    die("Error de conexion: " . $conexion->connect_error);
}


$correo = $_POST['correo'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);


$sql = "INSERT INTO usuarios (correo, contrasena) VALUES (?, ?)";
$consultar = $conexion->prepare($sql);


if (!$consultar) {
    die("Error en prepare: " . $conexion->error);
}


$consultar->bind_param("ss", $correo, $contrasena);


if ($consultar->execute()) {
    
    $usuario_id = $conexion->insert_id;
    $_SESSION['usuario_id'] = $usuario_id;
    echo "Registro exitoso ✅";
} else {
    echo "Error al registrar: " . $consultar->error;
}


$consultar->close();
$conexion->close();
?>