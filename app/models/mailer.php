<?php
require_once dirname(dirname(dirname(__FILE__))) . '/PHPMailer/src/PHPMailer.php';
require_once dirname(dirname(dirname(__FILE__))) . '/PHPMailer/src/SMTP.php';
require_once dirname(dirname(dirname(__FILE__))) . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class Mailer
{
    public function sendVerificationCode($email, $verificationCode)
    {
        $mail = new PHPMailer(true);
        try {
            // Email config
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ngongocanh15072311@gmail.com';
            $mail->Password = 'dpjr otuv enqy otax';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ngongocanh15072311@gmail.com', 'babyStress');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Verification code';
            $mail->Body = "Your verification code is: <b>$verificationCode</b>";

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Could not send email: " . $mail->ErrorInfo);
            return false;
        }
    }
}

