<?php
session_start();
include("conexion.php");
//include("verificarsesion.php");

if (isset($_POST['correo'], $_POST['password'])) {
    $correo = $_POST['correo'];
    $password = sha1($_POST['password']);

    // Rol por defecto
    $rol = 'cliente';

    // Si es admin y envió un rol personalizado
    if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin' && isset($_POST['rol'])) {
        $rol = $_POST['rol'];
    }

    // Verificar si ya existe
    $check = $con->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $check->bind_param("s", $correo);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo json_encode([
            "status" => "error",
            "mensaje" => "Este correo ya está registrado."
        ]);
        $check->close();
        exit;
    }

    $check->close();

    // Insertar usuario
    $stmt = $con->prepare("INSERT INTO usuarios (correo, password, rol) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $correo, $password, $rol);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "mensaje" => "Usuario creado con éxito. Por favor, inicia sesión."
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "mensaje" => "Error al crear usuario: " . $stmt->error
        ]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode([
        "status" => "error",
        "mensaje" => "Faltan datos."
    ]);
}
?>