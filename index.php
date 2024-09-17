<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro - Startup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1abc9c, #16a085);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            background-color: #ffffff;
        }
        .btn-startup {
            background-color: #1abc9c;
            color: white;
            font-weight: 600;
        }
        .btn-startup:hover {
            background-color: #16a085;
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .toggle-form {
            cursor: pointer;
            color: #1abc9c;
            font-weight: 600;
        }
        h2 {
            font-weight: 600;
        }
        .logo {
            font-size: 2rem;
            color: #1abc9c;
            text-align: center;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #dc3545;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="logo">
            Mineria de Datos
        </div>
        <div class="form-header">
            <h2 id="formTitle">Iniciar Sesión</h2>
        </div>

        <?php
            if (isset($_GET['error'])) {
                $error = htmlspecialchars($_GET['error']);
                echo "<div class='alert alert-danger'>$error</div>";
            }
        ?>

        <!-- Formulario de Login -->
        <form id="loginForm" action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-startup w-100">Iniciar Sesión</button>
            <p class="text-center mt-3">¿No tienes cuenta? <span class="toggle-form">Regístrate aquí</span></p>
        </form>

        <!-- Formulario de Registro (oculto por defecto) -->
        <form id="registerForm" action="register.php" method="POST" style="display: none;">
            <div class="mb-3">
                <label for="registerUsername" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="registerUsername" name="username" required>
            </div>
            <div class="mb-3">
                <label for="registerPassword" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="registerPassword" name="password" required>
            </div>
            <button type="submit" class="btn btn-startup w-100">Registrarse</button>
            <p class="text-center mt-3">¿Ya tienes cuenta? <span class="toggle-form">Inicia sesión aquí</span></p>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script para cambiar entre Login y Registro -->
<script>
    const toggleFormText = document.querySelectorAll('.toggle-form');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const formTitle = document.getElementById('formTitle');

    toggleFormText.forEach(el => {
        el.addEventListener('click', () => {
            loginForm.style.display = loginForm.style.display === 'none' ? 'block' : 'none';
            registerForm.style.display = registerForm.style.display === 'none' ? 'block' : 'none';
            formTitle.innerText = formTitle.innerText === 'Iniciar Sesión' ? 'Registro' : 'Iniciar Sesión';
        });
    });
</script>
</body>
</html>
