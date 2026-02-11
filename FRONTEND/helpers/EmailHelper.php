<?php

/**
 * Helper para envío de correos electrónicos con PHPMailer
 * Usa variables de entorno para mayor seguridad
 * 
 * @author Tu Nombre
 * @version 3.0 - Con variables de entorno
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Cargar PHPMailer
require_once __DIR__ . '/../vendor/autoload.php';

class EmailHelper {
    
    /**
     * Configuración desde variables de entorno
     */
    private static $configurado = false;
    private static $smtpHost;
    private static $smtpPort;
    private static $smtpSecure;
    private static $smtpUser;
    private static $smtpPass;
    private static $remitente;
    private static $nombreTienda;
    
    /**
     * Cargar configuración desde .env
     */
    private static function cargarConfiguracion() {
        if (self::$configurado) {
            return;
        }
        
        // Cargar variables de entorno
        $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
        
        // Obtener valores
        self::$smtpHost = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
        self::$smtpPort = $_ENV['SMTP_PORT'] ?? 587;
        self::$smtpSecure = $_ENV['SMTP_SECURE'] ?? 'tls';
        self::$smtpUser = $_ENV['SMTP_USER'];
        self::$smtpPass = $_ENV['SMTP_PASS'];
        self::$remitente = $_ENV['SMTP_FROM_EMAIL'] ?? 'noreply@latiendita.com';
        self::$nombreTienda = $_ENV['SMTP_FROM_NAME'] ?? 'La Tiendita de Siempre';
        
        self::$configurado = true;
    }
    
    /**
     * Enviar email de recuperación de contraseña
     * 
     * @param string $destinatario Email del destinatario
     * @param string $nombreUsuario Nombre del usuario
     * @param string $token Token de recuperación
     * @return bool True si se envió correctamente
     */
    public static function enviarRecuperacion($destinatario, $nombreUsuario, $token) {
        // Cargar configuración
        self::cargarConfiguracion();
        
        $mail = new PHPMailer(true);
        
        try {
            // ===== CONFIGURACIÓN DEL SERVIDOR SMTP =====
            $mail->isSMTP();
            $mail->Host       = self::$smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = self::$smtpUser;
            $mail->Password   = self::$smtpPass;
            
            // Configurar encriptación
            if (self::$smtpSecure === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }
            
            $mail->Port = self::$smtpPort;
            
            // ===== CODIFICACIÓN =====
            $mail->CharSet = 'UTF-8';
            
            // ===== REMITENTE =====
            $mail->setFrom(self::$smtpUser, self::$nombreTienda);
            
            // ===== DESTINATARIO =====
            $mail->addAddress($destinatario, $nombreUsuario);
            
            // ===== RESPONDER A =====
            $mail->addReplyTo(self::$smtpUser, self::$nombreTienda);
            
            // ===== CONTENIDO DEL EMAIL =====
            $mail->isHTML(true);
            $mail->Subject = 'Recuperación de Contraseña - ' . self::$nombreTienda;
            
            // Generar URL de recuperación
            $urlBase = self::obtenerUrlBase();
            $urlRecuperacion = $urlBase . "index.php?route=restablecer_password&token=" . $token;
            
            // Cuerpo del email en HTML
            $mail->Body = self::plantillaRecuperacion($nombreUsuario, $urlRecuperacion);
            
            // Versión en texto plano
            $mail->AltBody = "Hola {$nombreUsuario},\n\n"
                           . "Recibimos una solicitud para restablecer tu contraseña.\n\n"
                           . "Copia y pega este enlace en tu navegador:\n"
                           . $urlRecuperacion . "\n\n"
                           . "Este enlace expirará en 1 hora.\n\n"
                           . "Si no solicitaste este cambio, ignora este correo.\n\n"
                           . "Saludos,\n"
                           . self::$nombreTienda;
            
            // ===== ENVIAR EMAIL =====
            $mail->send();
            
            return true;
            
        } catch (Exception $e) {
            error_log("Error PHPMailer al enviar a {$destinatario}: {$mail->ErrorInfo}");
            return false;
        }
    }
    
    /**
     * Plantilla HTML para email de recuperación
     */
    private static function plantillaRecuperacion($nombreUsuario, $urlRecuperacion) {
        return '
        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Recuperación de Contraseña</title>
        </head>
        <body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 10px;">
                <div style="text-align: center; margin-bottom: 30px;">
                    <h1 style="color: #28a745; margin: 0;">' . self::$nombreTienda . '</h1>
                    <p style="color: #6c757d; margin: 5px 0;">Tu tienda de barrio de confianza</p>
                </div>
                
                <div style="background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <h2 style="color: #333; margin-top: 0;">¡Hola, ' . htmlspecialchars($nombreUsuario) . '!</h2>
                    
                    <p>Recibimos una solicitud para restablecer la contraseña de tu cuenta.</p>
                    
                    <p>Si fuiste tú quien solicitó este cambio, haz clic en el siguiente botón:</p>
                    
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . htmlspecialchars($urlRecuperacion) . '" 
                           style="background-color: #28a745; 
                                  color: white; 
                                  padding: 15px 30px; 
                                  text-decoration: none; 
                                  border-radius: 5px; 
                                  display: inline-block;
                                  font-weight: bold;">
                            🔐 Restablecer Contraseña
                        </a>
                    </div>
                    
                    <p style="color: #6c757d; font-size: 14px;">
                        O copia y pega este enlace en tu navegador:<br>
                        <a href="' . htmlspecialchars($urlRecuperacion) . '" style="color: #007bff; word-break: break-all;">
                            ' . htmlspecialchars($urlRecuperacion) . '
                        </a>
                    </p>
                    
                    <div style="background-color: #fff3cd; 
                                border-left: 4px solid #ffc107; 
                                padding: 15px; 
                                margin: 20px 0;">
                        <p style="margin: 0; color: #856404;">
                            <strong>⚠️ Importante:</strong> Este enlace expirará en 1 hora por seguridad.
                        </p>
                    </div>
                    
                    <p style="color: #6c757d; font-size: 14px;">
                        Si no solicitaste este cambio, puedes ignorar este correo. 
                        Tu contraseña permanecerá sin cambios.
                    </p>
                </div>
                
                <div style="text-align: center; margin-top: 30px; color: #6c757d; font-size: 12px;">
                    <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
                    <p>© ' . date('Y') . ' ' . self::$nombreTienda . '. Todos los derechos reservados.</p>
                </div>
            </div>
        </body>
        </html>
        ';
    }
    
    /**
     * Obtener URL base del sitio
     */
    private static function obtenerUrlBase() {
        $protocolo = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $carpeta = dirname($_SERVER['PHP_SELF']);
        
        if (substr($carpeta, -1) !== '/') {
            $carpeta .= '/';
        }
        
        return $protocolo . "://" . $host . $carpeta;
    }
    
    /**
     * Verificar configuración
     */
    public static function verificarConfiguracion() {
        self::cargarConfiguracion();
        
        $errores = [];
        
        if (empty(self::$smtpUser)) {
            $errores[] = 'SMTP_USER no configurado en .env';
        }
        
        if (empty(self::$smtpPass)) {
            $errores[] = 'SMTP_PASS no configurado en .env';
        }
        
        if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
            $errores[] = 'PHPMailer no está instalado';
        }
        
        return [
            'valido' => empty($errores),
            'errores' => $errores
        ];
    }
    
    /**
     * Email de prueba
     */
    public static function enviarEmailPrueba($emailPrueba) {
        self::cargarConfiguracion();
        
        $mail = new PHPMailer(true);
        
        try {
            $mail->isSMTP();
            $mail->Host       = self::$smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = self::$smtpUser;
            $mail->Password   = self::$smtpPass;
            
            if (self::$smtpSecure === 'tls') {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            } else {
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            }
            
            $mail->Port = self::$smtpPort;
            $mail->CharSet = 'UTF-8';
            
            $mail->setFrom(self::$smtpUser, self::$nombreTienda);
            $mail->addAddress($emailPrueba);
            
            $mail->isHTML(true);
            $mail->Subject = '✅ Email de Prueba - PHPMailer';
            $mail->Body    = '<h1>¡Funciona!</h1><p>PHPMailer con variables de entorno está configurado correctamente.</p>';
            $mail->AltBody = 'Funciona! PHPMailer está configurado correctamente.';
            
            $mail->send();
            return true;
            
        } catch (Exception $e) {
            error_log("Error en email de prueba: {$mail->ErrorInfo}");
            return false;
        }
    }
}