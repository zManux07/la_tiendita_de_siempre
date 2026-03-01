<?php
// Incluir header común
require_once __DIR__ . '/../frontend/header.php';
?>

<style>
    .recuperacion-container {
        max-width: 450px;
        margin: 50px auto;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .recuperacion-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .recuperacion-header h1 {
        color: #28a745;
        margin-bottom: 10px;
    }

    .recuperacion-header p {
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
    }

    .btn-recuperar {
        width: 100%;
        padding: 12px;
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
    }

    .btn-recuperar:hover {
        background-color: #218838;
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

    .alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .info-box {
        background-color: #e7f3ff;
        border-left: 4px solid #2196F3;
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
</style>

<div class="recuperacion-container">

    <div class="recuperacion-header">
        <h1>🔑 Recuperar Contraseña</h1>
        <p>Ingresa tu email y te enviaremos instrucciones</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <div class="info-box">
        📧 Te enviaremos un enlace a tu correo electrónico para restablecer tu contraseña.
    </div>

    <form action="index.php?route=recuperar_password/procesar" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" name="email" id="email" required>
        </div>

        <button type="submit" class="btn-recuperar">
            📧 Enviar Instrucciones
        </button>
    </form>

    <div style="text-align:center; margin-top:20px;">
        <a href="index.php?route=login">← Volver al login</a>
    </div>

</div>

<script>
    document.querySelector('form').addEventListener('submit', function (e) {
        const email = document.getElementById('email').value;
        if (!email.includes('@')) {
            e.preventDefault();
            alert('Ingresa un email válido');
        }
    });
</script>

<?php
// Incluir footer común
require_once __DIR__ . '/../frontend/footer.php';
?>