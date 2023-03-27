
<?php

class MailSender
{
    private $recipientEmail = "thecoderaptors0@gmail.com";
    private $backupDir = __DIR__ . '/../../backups/';

    public function __construct($backupDir = null)
    {
        if ($backupDir != null) $this->backupDir = $backupDir;
    }

    public function send($senderEmail, $senderName, $subject, $message, $mailType = "test", $recipientEmail = null)
    {
        $recipientEmail = ($recipientEmail != null) ? $recipientEmail : $this->recipientEmail;
        $headers = 'From: ' . $senderName . ' <' . $senderEmail . ">\r\n" .
            'Reply-To: ' . $senderEmail . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $isSent = mail($recipientEmail, $subject, $message, $headers);

        // Save email details in backup files
        if ($this->backupDir !== null) {
            $backupPath = rtrim($this->backupDir, '/') . '/mails/';

            // Create backup directory if it doesn't exist
            if (!is_dir($backupPath)) {
                mkdir($backupPath, 0777, true);
            }

            $filename = $backupPath . $mailType . "_" . ($isSent ? 'ok' : 'err') . '.txt';
            $content = date('Y-m-d_H-i-s_') . "\nTo: {$recipientEmail}\nSubject: {$subject}\n\n{$message}\n============================\n";

            file_put_contents($filename, $content, FILE_APPEND);
        }

        if ($isSent) {
            return true;
        } else {
            throw new Exception('Message could not be sent.');
        }
    }
}
