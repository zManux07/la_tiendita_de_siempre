<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - La Tiendita de Siempre</title>
    <link rel="stylesheet" href="assets/css/styles.css">
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
            transition: border-color 0.3s;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #28a745;
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
            transition: background-color 0.3s;
        }
        
        .btn-recuperar:hover {
            background-color: #218838;
        }
        
        .volver-login {
            text-align: center;
            margin-top: 20px;
        }
        
        .volver-login a {
            color: #007bff;
            text-decoration: none;
        }
        
        .volver-login a:hover {
            text-decoration: underline;
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
        
        .info-box p {
            margin: 0;
            color: #004085;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="recuperacion-container">
        <!-- Header -->
        <div class="recuperacion-header">
            <h1>🔑 Recuperar Contraseña</h1>
            <p>Ingresa tu email y te enviaremos instrucciones</p>
        </div>
        
        <!-- Mensajes de error/éxito -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                echo htmlspecialchars($_SESSION['error']); 
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                echo htmlspecialchars($_SESSION['success']); 
                unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>
        
        <!-- Información -->
        <div class="info-box">
            <p>
                📧 Te enviaremos un enlace a tu correo electrónico para 
                que puedas restablecer tu contraseña de forma segura.
            </p>
        </div>
        
        <!-- Formulario -->
        <form action="index.php?route=recuperar_password/procesar" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="ejemplo@correo.com"
                    required
                    autocomplete="email"
                >
            </div>
            
            <button type="submit" class="btn-recuperar">
                📧 Enviar Instrucciones
            </button>
        </form>
        
        <!-- Volver al login -->
        <div class="volver-login">
            <p>
                ¿Recordaste tu contraseña? 
                <a href="index.php?route=login">Inicia sesión aquí</a>
            </p>
        </div>
    </div>
    
    <script>
        // Validación básica del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            
            if (!email || !email.includes('@')) {
                e.preventDefault();
                alert('Por favor ingresa un email válido');
                return false;
            }
        });
    </script>
</body>
</html>
