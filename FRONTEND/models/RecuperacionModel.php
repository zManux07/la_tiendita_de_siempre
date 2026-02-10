<?php

/**
 * Modelo para gestionar la recuperación de contraseñas
 * 
 * @author Tu Nombre
 * @version 1.0
 */
class RecuperacionModel {
    private $db;
    
    /**
     * Constructor
     * @param PDO $database Conexión a la base de datos
     */
    public function __construct($database) {
        $this->db = $database;
    }
    
    /**
     * Generar y guardar token de recuperación
     * 
     * @param string $email Email del usuario
     * @return string|false Token generado o false si falla
     */
    public function generarTokenRecuperacion($email) {
        // Verificar que el email existe
        $usuario = $this->obtenerPorEmail($email);
        
        if (!$usuario) {
            return false;
        }
        
        // Generar token seguro
        $token = bin2hex(random_bytes(32)); // 64 caracteres hexadecimales
        
        // Establecer tiempo de expiración (1 hora)
        $expira = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Guardar token en la base de datos
        $query = "UPDATE usuario 
                  SET reset_token = ?, 
                      reset_token_expira = ? 
                  WHERE emailUSUARIO = ?";
        
        $stmt = $this->db->prepare($query);
        
        if ($stmt->execute([$token, $expira, $email])) {
            return $token;
        }
        
        return false;
    }
    
    /**
     * Validar token de recuperación
     * 
     * @param string $token Token a validar
     * @return array|false Datos del usuario o false si es inválido
     */
    public function validarToken($token) {
        $query = "SELECT * FROM usuario 
                  WHERE reset_token = ? 
                  AND reset_token_expira > NOW()";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute([$token]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Restablecer contraseña usando token
     * 
     * @param string $token Token de recuperación
     * @param string $nuevaPassword Nueva contraseña
     * @return bool True si fue exitoso
     */
    public function restablecerPassword($token, $nuevaPassword) {
        // Validar token
        $usuario = $this->validarToken($token);
        
        if (!$usuario) {
            return false;
        }
        
        // Hash de la nueva contraseña
        $passwordHash = password_hash($nuevaPassword, PASSWORD_BCRYPT);
        
        // Actualizar contraseña y limpiar token
        $query = "UPDATE usuario 
                  SET pass = ?, 
                      reset_token = NULL, 
                      reset_token_expira = NULL 
                  WHERE idUSUARIO = ?";
        
        $stmt = $this->db->prepare($query);
        
        return $stmt->execute([$passwordHash, $usuario['idUSUARIO']]);
    }
    
    /**
     * Obtener usuario por email
     * 
     * @param string $email
     * @return array|false
     */
    private function obtenerPorEmail($email) {
        $query = "SELECT * FROM usuario WHERE emailUSUARIO = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Limpiar tokens expirados (mantenimiento)
     * Se puede ejecutar con un cron job
     * 
     * @return int Número de tokens eliminados
     */
    public function limpiarTokensExpirados() {
        $query = "UPDATE usuario 
                  SET reset_token = NULL, 
                      reset_token_expira = NULL 
                  WHERE reset_token_expira < NOW()";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        return $stmt->rowCount();
    }
}
