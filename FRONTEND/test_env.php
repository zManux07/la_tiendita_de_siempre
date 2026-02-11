<?php
require_once 'vendor/autoload.php';
require_once 'helpers/EmailHelper.php';

echo "<h1>🧪 Prueba de Configuración .env</h1>";

// Verificar configuración
$verificacion = EmailHelper::verificarConfiguracion();

if ($verificacion['valido']) {
    echo "<p style='color: green;'>✅ Configuración correcta</p>";
    
    // Intentar enviar email de prueba
    $emailPrueba = 'mfds.camilo@gmail.com'; // Cambia esto
    
    echo "<p>Enviando email de prueba a: <strong>{$emailPrueba}</strong></p>";
    
    if (EmailHelper::enviarEmailPrueba($emailPrueba)) {
        echo "<p style='color: green;'>✅ Email enviado correctamente!</p>";
    } else {
        echo "<p style='color: red;'>❌ Error al enviar email</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Errores de configuración:</p>";
    echo "<ul>";
    foreach ($verificacion['errores'] as $error) {
        echo "<li>{$error}</li>";
    }
    echo "</ul>";
}
?>