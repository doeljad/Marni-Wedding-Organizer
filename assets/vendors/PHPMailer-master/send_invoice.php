<?php
// Include PHPMailer classes
require 'src/Exception.php';
require 'src/PHPMailer.php';
require 'src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendInvoiceEmail($email, $invoicePdfPath, $message)
{
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 0;                                      // Disable verbose debug output
        $mail->isSMTP();                                           // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                  // Enable SMTP authentication
        $mail->Username   = 'marniweddingorganizer@gmail.com';              // SMTP username
        $mail->Password   = 'qahb iouf jmam vpgl';                 // SMTP password
        $mail->SMTPSecure = 'tls';                                 // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                   // TCP port to connect to

        //Recipients
        $mail->setFrom('marniweddingorganizer@gmail.com', 'Marni Wedding Organizer');
        $mail->addAddress($email);                                 // Add a recipient

        // Attachments
        $mail->addAttachment($invoicePdfPath);                     // Add attachments

        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = 'Invoice Pembayaran Transaksi';
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
