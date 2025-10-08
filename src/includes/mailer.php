<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

function sendLectureNotification($toEmail, $courseName, $lectureTitle, $downloadLink) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = getenv('SMTP_HOST') ?: 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = getenv('SMTP_USER') ?: '';
        $mail->Password = getenv('SMTP_PASS') ?: '';
        $port = getenv('SMTP_PORT') ?: 587;
        $mail->SMTPSecure = getenv('SMTP_SECURE') ?: 'tls';
        $mail->Port = $port;
        $mail->setFrom(getenv('SMTP_USER'), 'BSU Engineering');
        $mail->addAddress($toEmail);
        $mail->isHTML(true);
        $mail->Subject = "New Lecture Uploaded: {$lectureTitle}";
        $body = "<p>A new lecture has been uploaded for <strong>{$courseName}</strong>.</p>";
        $body .= "<p>Lecture: <strong>{$lectureTitle}</strong></p>";
        $body .= "<p><a href='{$downloadLink}'>Download Lecture</a></p>";
        $mail->Body = $body;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log('Mailer Error: '.$e->getMessage());
        return false;
    }
}
