<?php

require_once __DIR__ . '\scripts\classes\mail.class.php';

$senderEmail = 'ryoutaroshinigami@gmail.com';
$senderName = 'Shinigami Ryoutaro';

$mailSender = new MailSender();

$subject = 'Test Email';
$message = 'This is a test email sent using the built-in mail() function.';

try {
    $mailSender->send($senderEmail, $senderName, $subject, $message);
    echo 'Email sent successfully';
} catch (Exception $e) {
    echo 'Unable to send email: ' . $e->getMessage();
}
