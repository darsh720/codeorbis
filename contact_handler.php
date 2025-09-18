<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'] ?? '';
    $lastName  = $_POST['lastName'] ?? '';
    $email     = $_POST['email'] ?? '';
    $phone     = $_POST['phone'] ?? '';
    $company   = $_POST['company'] ?? '';
    $service   = $_POST['service'] ?? '';
    $budget    = $_POST['budget'] ?? '';
    $message   = $_POST['message'] ?? '';

    $mail = new PHPMailer(true);
    try {
        // SMTP settings (Zoho/Gmail/etc.)
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // change to smtp.zoho.in when ready
        $mail->SMTPAuth   = true;
        $mail->Username   = 'darshanpatel4456@gmail.com';  // replace
        $mail->Password   = 'lfxf zqpr gtvj qchq';     // replace
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('darshanpatel4456@gmail.com', 'CodeOrbis Website');
        $mail->addAddress('dp2473229@gmail.com'); // destination mailbox
        $mail->addReplyTo($email, $firstName . ' ' . $lastName);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission";
        $mail->Body    = "
            <h2>New Message from CodeOrbis Website</h2>
            <p><strong>Name:</strong> $firstName $lastName</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Company:</strong> $company</p>
            <p><strong>Service Interested In:</strong> $service</p>
            <p><strong>Project Budget:</strong> $budget</p>
            <p><strong>Message:</strong><br>$message</p>
        ";

        $mail->AltBody = "
        Name: $firstName $lastName
        Email: $email
        Phone: $phone
        Company: $company
        Service: $service
        Budget: $budget

        Message:
        $message
        ";

        $mail->send();
        echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
