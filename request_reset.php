<?php
include "Database.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    // Check if email exists
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Generate a unique reset code
        $code = rand(100000,999999);

        // Store reset code in database
        $sql = "UPDATE user SET code = '$code' WHERE email = '$email'";
        if (mysqli_query($conn, $sql)) {
            // Send reset code via email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'nischal.201720@ncit.edu.np';
                $mail->Password = 'ojdckkrwsumzunrl';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
                $mail->setFrom('nischal.201720@ncit.edu.np', 'Nischal Dhakal');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Code';
                $mail->Body = 'Your password reset code is: <b>' . $code . '</b>';
                $mail->send();
                echo 'Check your email for the password reset code.';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Failed to create reset request. Please try again.";
        }
    } else {
        echo "Email not found.";
    }
}
?>
