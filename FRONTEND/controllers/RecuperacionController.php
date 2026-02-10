<?php

require_once 'models/RecuperacionModel.php';
require_once 'helpers/EmailHelper.php';

/**
 * Controlador para gestionar recuperación de contraseñas
 * 
 * @author Tu Nombre
 * @version 1.0
 */
class RecuperacionController {
    private $recuperacionModel;
    private $usuarioModel;
    
    /**
     * Constructor
     * @param PDO $database Conexión a la base de datos
     */
    public function __construct($database) {
        $this->recuperacionModel = new RecuperacionModel($database);
        require_once 'models/UsuarioModel.php';
        $this->usuarioModel = new UsuarioModel($database);
    }
    
    /**
     * Mostrar formulario de solicitud de recuperación
     * 
     * @return string Ruta de la vista
     */
    public function solicitarRecuperacion() {
        return 'views/auth/solicitar_recuperacion.php';
    }
    
    /**
     * Procesar solicitud de recuperación
     * Enviar email con link de recuperación
     */
    public function procesarSolicitud() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=recuperar_password');
            exit;
        }
        
        $email = trim($_POST['email'] ?? '');
        
        // Validar email
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Por favor ingresa un email válido';
            header('Location: index.php?route=recuperar_password');
            exit;
        }
        
        // Verificar que el usuario existe
        $usuario = $this->usuarioModel->obtenerPorEmail($email);
        
        if (!$usuario) {
            // Por seguridad, no revelamos si el email existe o no
            $_SESSION['success'] = 'Si el email existe en nuestro sistema, recibirás instrucciones para recuperar tu contraseña.';
            header('Location: index.php?route=login');
            exit;
        }
        
        // Generar token
        $token = $this->recuperacionModel->generarTokenRecuperacion($email);
        
        if (!$token) {
            $_SESSION['error'] = 'Hubo un error al procesar tu solicitud. Intenta nuevamente.';
            header('Location: index.php?route=recuperar_password');
            exit;
        }
        
        // Enviar email
        $emailEnviado = EmailHelper::enviarRecuperacion(
            $email,
            $usuario['nomUSUARIO'],
            $token
        );
        
        if ($emailEnviado) {
            $_SESSION['success'] = 'Se ha enviado un email con instrucciones para recuperar tu contraseña.';
        } else {
            // Logear el error pero mostrar mensaje genérico al usuario
            error_log("Error al enviar email de recuperación a: " . $email);
            $_SESSION['success'] = 'Tu solicitud ha sido procesada. Revisa tu correo electrónico.';
        }
        
        header('Location: index.php?route=login');
        exit;
    }
    
    /**
     * Mostrar formulario de restablecimiento de contraseña
     * 
     * @return string Ruta de la vista
     */
    public function mostrarFormularioRestablecimiento() {
        $token = $_GET['token'] ?? '';
        
        // Validar token
        if (empty($token)) {
            $_SESSION['error'] = 'Token de recuperación inválido';
            header('Location: index.php?route=login');
            exit;
        }
        
        // Verificar que el token sea válido
        $usuario = $this->recuperacionModel->validarToken($token);
        
        if (!$usuario) {
            $_SESSION['error'] = 'El enlace de recuperación ha expirado o es inválido. Por favor solicita uno nuevo.';
            header('Location: index.php?route=recuperar_password');
            exit;
        }
        
        // El token es válido, mostrar formulario
        return 'views/auth/restablecer_password.php';
    }
    
    /**
     * Procesar restablecimiento de contraseña
     */
    public function restablecerPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?route=login');
            exit;
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';
        
        // Validaciones
        if (empty($token) || empty($password) || empty($passwordConfirm)) {
            $_SESSION['error'] = 'Por favor completa todos los campos';
            header('Location: index.php?route=restablecer_password&token=' . urlencode($token));
            exit;
        }
        
        // Verificar que las contraseñas coincidan
        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = 'Las contraseñas no coinciden';
            header('Location: index.php?route=restablecer_password&token=' . urlencode($token));
            exit;
        }
        
        // Validar fortaleza de la contraseña
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'La contraseña debe tener al menos 6 caracteres';
            header('Location: index.php?route=restablecer_password&token=' . urlencode($token));
            exit;
        }
        
        // Restablecer contraseña
        $resultado = $this->recuperacionModel->restablecerPassword($token, $password);
        
        if ($resultado) {
            $_SESSION['success'] = '¡Contraseña restablecida exitosamente! Ya puedes iniciar sesión.';
            header('Location: index.php?route=login');
        } else {
            $_SESSION['error'] = 'El enlace de recuperación ha expirado. Por favor solicita uno nuevo.';
            header('Location: index.php?route=recuperar_password');
        }
        
        exit;
    }
}
