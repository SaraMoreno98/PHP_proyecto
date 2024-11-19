<?php
include_once 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

/**
 * Clase Correo
 * Maneja el envío de correos electrónicos usando PHPMailer
 */
class Correo{
    /**
     * Envía un correo electrónico usando la configuración SMTP especificada
     * @param string $forEmail Dirección de correo del destinatario
     * @param string $forName Nombre del destinatario
     * @param string $asunto Asunto del correo
     * @param string $body Cuerpo del mensaje
     * @return array Resultado del envío ['success' => bool, 'message' => string]
     */
    public static function enviarCorreo($forEmail, $forName, $asunto, $body){

    $mail = new PHPMailer(true);


    try {
        // Configuración de depuración
        $mail->SMTPDebug = 2; // Habilita la salida de depuración detallada
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer: $str");
        };

        // Configuración del servidor SMTP
        $mail->isSMTP();                // Send using SMTP
        $mail->Host = MAIL_HOST;  // Set the SMTP server to send through
        $mail->SMTPAuth = true;       // Enable SMTP authentication
        $mail->Username = MAIL_USER;  // SMTP username
        $mail->Password = MAIL_PASS;  // SMTP password
        $mail->From = MAIL_USER; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587;  
        
        // Configuración de codificación
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        // Configuración del remitente y destinatario
        $mail->setFrom(MAIL_USER, '=?UTF-8?B?'.base64_encode('Administración').'?=');
        $mail->addAddress($forEmail, '=?UTF-8?B?'.base64_encode($forName).'?=');

        // Configuración del contenido
        $mail->isHTML(true); // Permite el formato HTML
        $mail->Subject = '=?UTF-8?B?'.base64_encode($asunto).'?=';
        $mail->Body    = '
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            </head>
            <body>
                '.nl2br(htmlspecialchars($body)).'
            </body>
        </html>';

        $mail->AltBody = $body; // Versión en texto plano

        // Enviar el correo
        if(!$mail->send()){
            error_log("Error al enviar correo: " . $mail->ErrorInfo);
            return ["success" => false, "message" => 'El correo no pudo ser enviado: ' . $mail->ErrorInfo];
        } else {
            error_log("Correo enviado exitosamente a: $forEmail");
            return ["success" =>true, "message" => "Registro exitoso. Por favor, verifica tu correo."];
        }
        }catch(Exception $e){
            return ["success" => false, "message" => 'Error al enviar el formulario'];
        }
    }
}