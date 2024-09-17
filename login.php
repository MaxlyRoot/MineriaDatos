<?php
require 'db.php'; // Archivo con la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Consultar si el usuario existe
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        // Usuario no existe
        header('Location: index.php?error=Usuario no encontrado.');
        exit();
    }

    // Obtener datos del usuario
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    // Verificar la contraseña
    if (!password_verify($password, $hashed_password)) {
        // Contraseña incorrecta
        header('Location: index.php?error=Contraseña incorrecta.');
        exit();
    }

    // Contraseña correcta, iniciar sesión y redirigir al dashboard
    session_start();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $username;

    // Redirigir al dashboard
    header('Location: dashboard.php');
    exit();

    $stmt->close();
    $conn->close();
}
