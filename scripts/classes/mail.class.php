<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use League\OAuth2\Client\Provider\Google;

class MailSender
{

    private $client;
    private $accessToken;

    private $clientId = "";
    private $clientSecret = "";
    private $redirectUri = "";
    private $refreshToken = "";


    public function __construct($clientId = null, $clientSecret = null, $redirectUri = null, $refreshToken = null)
    {
        $clientId = ($clientId == null) ? $this->clientId : $clientId;
        $clientSecret = ($clientSecret == null) ? $this->clientSecret : $clientSecret;
        $redirectUri = ($redirectUri == null) ? $this->redirectUri : $redirectUri;
        $refreshToken = ($refreshToken == null) ? $this->refreshToken : $refreshToken;

        // Create a new Google OAuth2 client
        $this->client = new Google([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ]);

        // Get an access token using the provided refresh token
        $this->accessToken = $this->client->getAccessToken('refresh_token', [
            'refresh_token' => $refreshToken,
        ]);
    }

    public function send($senderName, $senderEmail, $recipientEmail, $subject, $message)
    {
        try {
            // Create a new PHPMailer instance
            $mail = new PHPMailer(true);

            // Configure SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Set OAuth2 authentication
            $mail->setOAuth2Client($this->client);
            $mail->setAccessToken($this->accessToken);

            // Set the sender's name and email address
            $mail->setFrom($senderEmail, $senderName);

            // Set the recipient's email address
            $mail->addAddress($recipientEmail);

            // Set the email subject and body
            $mail->Subject = $subject;
            $mail->Body = $message;

            // Send the email
            if (!$mail->send()) {
                throw new Exception('Unable to send email. ' . $mail->ErrorInfo);
            } else {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception('Unable to send email. ' . $e->getMessage());
        }
    }
}
