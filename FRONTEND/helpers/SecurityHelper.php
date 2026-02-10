<?php

/**
 * Helper de Seguridad y Validación
 * Funciones útiles para validar datos y prevenir ataques
 * 
 * INSTRUCCIONES:
 * 1. Guardar este archivo en: FRONTEND/helpers/SecurityHelper.php
 * 2. Incluirlo donde necesites: require_once 'helpers/SecurityHelper.php';
 * 
 * @author Tu Nombre
 * @version 1.0
 */
class SecurityHelper {
    
    /**
     * Validar email
     * 
     * @param string $email Email a validar
     * @return bool True si es válido
     */
    public static function validarEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    /**
     * Validar fortaleza de contraseña
     * 
     * Requisitos:
     * - Mínimo 8 caracteres
     * - Al menos una mayúscula
     * - Al menos una minúscula
     * - Al menos un número
     * 
     * @param string $password Contraseña a validar
     * @return array ['valido' => bool, 'errores' => array]
     */
    public static function validarPassword($password) {
        $errores = [];
        
        if (strlen($password) < 8) {
            $errores[] = 'La contraseña debe tener al menos 8 caracteres';
        }
        
        if (!preg_match('/[a-z]/', $password)) {
            $errores[] = 'Debe contener al menos una letra minúscula';
        }
        
        if (!preg_match('/[A-Z]/', $password)) {
            $errores[] = 'Debe contener al menos una letra mayúscula';
        }
        
        if (!preg_match('/[0-9]/', $password)) {
            $errores[] = 'Debe contener al menos un número';
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
    
    /**
     * Sanitizar entrada de usuario
     * Elimina etiquetas HTML y espacios extra
     * 
     * @param string $data Dato a sanitizar
     * @return string Dato limpio
     */
    public static function sanitizar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }
    
    /**
     * Generar token CSRF
     * Protección contra Cross-Site Request Forgery
     * 
     * @return string Token generado
     */
    public static function generarTokenCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validar token CSRF
     * 
     * @param string $token Token a validar
     * @return bool True si es válido
     */
    public static function validarTokenCSRF($token) {
        if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
            return false;
        }
        return true;
    }
    
    /**
     * Limpiar token CSRF
     * Usar después de validar para regenerarlo
     */
    public static function limpiarTokenCSRF() {
        unset($_SESSION['csrf_token']);
    }
    
    /**
     * Verificar si es una solicitud POST
     * 
     * @return bool
     */
    public static function esPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Verificar si es una solicitud GET
     * 
     * @return bool
     */
    public static function esGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Obtener IP del cliente
     * Útil para logs y rate limiting
     * 
     * @return string IP del cliente
     */
    public static function obtenerIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }
    
    /**
     * Rate limiting simple
     * Limita intentos por IP
     * 
     * @param string $accion Identificador de la acción
     * @param int $maxIntentos Máximo de intentos permitidos
     * @param int $ventanaTiempo Ventana de tiempo en segundos
     * @return bool True si está dentro del límite
     */
    public static function verificarRateLimit($accion, $maxIntentos = 5, $ventanaTiempo = 300) {
        $ip = self::obtenerIP();
        $clave = "rate_limit_{$accion}_{$ip}";
        
        if (!isset($_SESSION[$clave])) {
            $_SESSION[$clave] = [
                'intentos' => 0,
                'ultimo_intento' => time()
            ];
        }
        
        $datos = $_SESSION[$clave];
        
        // Si pasó el tiempo de la ventana, resetear
        if (time() - $datos['ultimo_intento'] > $ventanaTiempo) {
            $_SESSION[$clave] = [
                'intentos' => 1,
                'ultimo_intento' => time()
            ];
            return true;
        }
        
        // Si superó el límite, denegar
        if ($datos['intentos'] >= $maxIntentos) {
            return false;
        }
        
        // Incrementar contador
        $_SESSION[$clave]['intentos']++;
        $_SESSION[$clave]['ultimo_intento'] = time();
        
        return true;
    }
    
    /**
     * Resetear rate limit para una acción e IP
     * 
     * @param string $accion
     */
    public static function resetearRateLimit($accion) {
        $ip = self::obtenerIP();
        $clave = "rate_limit_{$accion}_{$ip}";
        unset($_SESSION[$clave]);
    }
}


/**
 * Helper de Mensajes Flash
 * Para mostrar notificaciones al usuario
 * 
 * USO:
 * FlashHelper::success('Operación exitosa');
 * FlashHelper::error('Hubo un error');
 * 
 * En la vista:
 * FlashHelper::mostrar();
 */
class FlashHelper {
    
    /**
     * Establecer mensaje de éxito
     */
    public static function success($mensaje) {
        $_SESSION['flash_success'] = $mensaje;
    }
    
    /**
     * Establecer mensaje de error
     */
    public static function error($mensaje) {
        $_SESSION['flash_error'] = $mensaje;
    }
    
    /**
     * Establecer mensaje de advertencia
     */
    public static function warning($mensaje) {
        $_SESSION['flash_warning'] = $mensaje;
    }
    
    /**
     * Establecer mensaje de información
     */
    public static function info($mensaje) {
        $_SESSION['flash_info'] = $mensaje;
    }
    
    /**
     * Mostrar todos los mensajes flash
     * Inserta HTML directamente
     */
    public static function mostrar() {
        $tipos = ['success', 'error', 'warning', 'info'];
        
        foreach ($tipos as $tipo) {
            $clave = "flash_{$tipo}";
            
            if (isset($_SESSION[$clave])) {
                $mensaje = $_SESSION[$clave];
                $icono = self::obtenerIcono($tipo);
                $color = self::obtenerColor($tipo);
                
                echo "
                <div class='alert alert-{$tipo}' style='
                    padding: 15px;
                    margin-bottom: 20px;
                    border-radius: 5px;
                    background-color: {$color['bg']};
                    border: 1px solid {$color['border']};
                    color: {$color['text']};
                '>
                    {$icono} " . htmlspecialchars($mensaje) . "
                </div>
                ";
                
                unset($_SESSION[$clave]);
            }
        }
    }
    
    /**
     * Obtener icono según tipo
     */
    private static function obtenerIcono($tipo) {
        $iconos = [
            'success' => '✓',
            'error' => '✗',
            'warning' => '⚠',
            'info' => 'ℹ'
        ];
        
        return $iconos[$tipo] ?? '';
    }
    
    /**
     * Obtener colores según tipo
     */
    private static function obtenerColor($tipo) {
        $colores = [
            'success' => [
                'bg' => '#d4edda',
                'border' => '#c3e6cb',
                'text' => '#155724'
            ],
            'error' => [
                'bg' => '#f8d7da',
                'border' => '#f5c6cb',
                'text' => '#721c24'
            ],
            'warning' => [
                'bg' => '#fff3cd',
                'border' => '#ffeaa7',
                'text' => '#856404'
            ],
            'info' => [
                'bg' => '#d1ecf1',
                'border' => '#bee5eb',
                'text' => '#0c5460'
            ]
        ];
        
        return $colores[$tipo] ?? $colores['info'];
    }
    
    /**
     * Verificar si hay mensajes
     */
    public static function hayMensajes() {
        return isset($_SESSION['flash_success']) 
            || isset($_SESSION['flash_error'])
            || isset($_SESSION['flash_warning'])
            || isset($_SESSION['flash_info']);
    }
}


/**
 * EJEMPLOS DE USO:
 * 
 * // En un controlador:
 * if (SecurityHelper::esPost()) {
 *     if (!SecurityHelper::verificarRateLimit('login', 5, 300)) {
 *         FlashHelper::error('Demasiados intentos. Espera 5 minutos.');
 *         header('Location: login.php');
 *         exit;
 *     }
 *     
 *     $email = SecurityHelper::sanitizar($_POST['email']);
 *     
 *     if (!SecurityHelper::validarEmail($email)) {
 *         FlashHelper::error('Email inválido');
 *         header('Location: login.php');
 *         exit;
 *     }
 *     
 *     // Procesar login...
 *     
 *     if ($loginExitoso) {
 *         SecurityHelper::resetearRateLimit('login');
 *         FlashHelper::success('¡Bienvenido!');
 *     }
 * }
 * 
 * // En una vista:
 * <form method="POST">
 *     <input type="hidden" name="csrf_token" value="<?php echo SecurityHelper::generarTokenCSRF(); ?>">
 *     
 *     <?php FlashHelper::mostrar(); ?>
 *     
 *     <!-- Resto del formulario -->
 * </form>
 */
