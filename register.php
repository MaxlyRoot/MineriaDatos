<?php
require 'vendor/autoload.php';
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Validar si el usuario ya existe
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Usuario ya existe
        header('Location: index.php?error=El usuario ya existe.');
        exit();
    }

    // Registrar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña
    $stmt->bind_param("ss", $username, $hashed_password);

    if ($stmt->execute()) {
        // Registro exitoso
        header('Location: index.php?success=Registro exitoso. Puedes iniciar sesión.');
    } else {
        // Error en el registro
        header('Location: index.php?error=Error al registrar. Por favor, intenta de nuevo.');
    }

    $stmt->close();
    $conn->close();
}
