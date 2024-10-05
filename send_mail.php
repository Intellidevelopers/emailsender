<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $from_name = isset($_POST['from_name']) ? $_POST['from_name'] : 'Your Name';
    $from_email = isset($_POST['from_email']) ? $_POST['from_email'] : 'from_email@example.com';
    $recipient_name = isset($_POST['recipient_name']) ? $_POST['recipient_name'] : '';
    $recipient_email = isset($_POST['recipient_email']) ? $_POST['recipient_email'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : 'No Subject';
    $message = isset($_POST['message']) ? $_POST['message'] : ''; // You can keep this for the template, but we won't use it directly in the email body.

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Set the SMTP server (e.g., smtp.gmail.com for Gmail)
        $mail->SMTPAuth = true;
        $mail->Username = 'adeagbojosiah1@gmail.com'; // SMTP username
        $mail->Password = 'bvvmpoeglluldhwj';         // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption
        $mail->Port = 465; // TCP port to connect to

        // Set the custom "From" name and email
        $mail->setFrom($from_email, htmlspecialchars($from_name));

        // Add the recipient
        $mail->addAddress($recipient_email, htmlspecialchars($recipient_name));

        // Content
        $mail->isHTML(true);
        $mail->Subject = htmlspecialchars($subject);  // Set the subject from the form

        // Load the HTML template
        ob_start(); // Start output buffering
        include 'email_template.html'; // Include your HTML template
        $mail->Body = ob_get_clean(); // Get the buffered content and clean the buffer

        // Send the email
        $mail->send();
        echo "Message has been sent!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request!";
}
