<?php
require_once __DIR__ . '/../frontend/header.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - La Tiendita de Siempre</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .restablecer-container {
            max-width: 450px;
            margin: 50px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .restablecer-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .restablecer-header h1 {
            color: #28a745;
            margin-bottom: 10px;
        }
        .restablecer-header p {
            color: #6c757d;
            font-size: 14px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #28a745;
        }
        .password-toggle {
            position: relative;
        }
        .password-toggle-btn {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #6c757d;
        }
        .btn-restablecer {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .btn-restablecer:hover {
            background-color: #218838;
        }
        .btn-restablecer:disabled {
            background-color: #6c757d;
            cursor: not-allowed;
        }
        .alert {
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-danger {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
        .password-requirements {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .password-requirements h4 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #333;
        }
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
        }
        .password-requirements li {
            margin-bottom: 5px;
            color: #6c757d;
        }
        .password-requirements li.valid {
            color: #28a745;
        }
        .password-requirements li.invalid {
            color: #dc3545;
        }
        .password-strength {
            height: 5px;
            background-color: #e9ecef;
            border-radius: 3px;
            margin-top: 5px;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            transition: width 0.3s, background-color 0.3s;
            width: 0%;
        }
        .password-strength-bar.weak {
            background-color: #dc3545;
            width: 33%;
        }
        .password-strength-bar.medium {
            background-color: #ffc107;
            width: 66%;
        }
        .password-strength-bar.strong {
            background-color: #28a745;
            width: 100%;
        }
    </style>
</head>
<body>
<div class="restablecer-container">
    <div class="restablecer-header">
        <h1>🔐 Restablecer Contraseña</h1>
        <p>Crea una nueva contraseña segura</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="password-requirements">
        <h4>📋 Requisitos de la contraseña:</h4>
        <ul id="password-checklist">
            <li id="check-length">Mínimo 6 caracteres</li>
            <li id="check-match">Las contraseñas coinciden</li>
        </ul>
    </div>

    <form action="index.php?route=restablecer_password/procesar" method="POST" id="resetForm">
        <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token'] ?? ''); ?>">

        <div class="form-group">
            <label for="password">Nueva Contraseña</label>
            <div class="password-toggle">
                <input type="password" id="password" name="password" placeholder="Ingresa tu nueva contraseña" required minlength="6">
                <button type="button" class="password-toggle-btn" onclick="togglePassword('password')">👁️</button>
            </div>
            <div class="password-strength">
                <div class="password-strength-bar" id="strength-bar"></div>
            </div>
        </div>

        <div class="form-group">
            <label for="password_confirm">Confirmar Contraseña</label>
            <div class="password-toggle">
                <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirma tu nueva contraseña" required minlength="6">
                <button type="button" class="password-toggle-btn" onclick="togglePassword('password_confirm')">👁️</button>
            </div>
        </div>

        <button type="submit" class="btn-restablecer" id="submitBtn">🔐 Restablecer Contraseña</button>
    </form>
</div>

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function calcularFortaleza(password) {
        let fuerza = 0;
        if (password.length >= 6) fuerza++;
        if (password.length >= 10) fuerza++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) fuerza++;
        if (/[0-9]/.test(password)) fuerza++;
        if (/[^A-Za-z0-9]/.test(password)) fuerza++;
        return fuerza;
    }

    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strength-bar');
    const passwordConfirm = document.getElementById('password_confirm');

    function validarFormulario() {
        const password = passwordInput.value;
        const confirm = passwordConfirm.value;

        const checkLength = document.getElementById('check-length');
        checkLength.className = password.length >= 6 ? 'valid' : 'invalid';
        checkLength.textContent = password.length >= 6 ? '✓ Mínimo 6 caracteres' : '✗ Mínimo 6 caracteres';

        const checkMatch = document.getElementById('check-match');
        checkMatch.className = password && confirm && password === confirm ? 'valid' : 'invalid';
        checkMatch.textContent = password === confirm ? '✓ Las contraseñas coinciden' : '✗ Las contraseñas no coinciden';

        document.getElementById('submitBtn').disabled = !(password.length >= 6 && password === confirm);
    }

    passwordInput.addEventListener('input', validarFormulario);
    passwordConfirm.addEventListener('input', validarFormulario);
</script>

<?php
require_once __DIR__ . '/../frontend/footer.php';
?>
</body>
</html>