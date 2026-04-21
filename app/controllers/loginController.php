<?php
session_start();
include("../config/config.php");

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Manually require the PHPMailer files you just downloaded
// Bulletproof paths based on your exact folder structure
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // UPDATED: Now selecting `recovery_email`
    $loginQuery = "SELECT `id`, `uuid`, `username`, `password`, `recovery_email`, `role`, `two_factor_enabled` FROM `user` WHERE `username` = ? LIMIT 1";
    $stmt = $conn->prepare($loginQuery);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();

            if (password_verify($password, $data['password'])) {
                
                // --- 2FA LOGIC TRAFFIC COP ---
                if ($data['two_factor_enabled'] == 1 && !empty($data['recovery_email'])) {
                    // Generate a 6-digit code
                    $authCode = sprintf("%06d", mt_rand(1, 999999));
                    $expires = date("Y-m-d H:i:s", strtotime('+10 minutes'));

                    // Save code to DB
                    $updateCode = $conn->prepare("UPDATE `user` SET `two_factor_code` = ?, `two_factor_expires` = ? WHERE `id` = ?");
                    $updateCode->bind_param("ssi", $authCode, $expires, $data['id']);
                    $updateCode->execute();

                    // Send Email using PHPMailer
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com'; 
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'durain.jussyjay@gmail.com'; // YOUR GMAIL
                        $mail->Password   = 'ukzc hafs ekdi iieq'; // YOUR APP PASSWORD
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        $mail->setFrom('durain.jussyjay@gmail.com', 'USTP E-Gallery');
                        $mail->addAddress($data['recovery_email']); // UPDATED
                        
                        $mail->isHTML(true);
                        $mail->Subject = 'Your 2FA Login Code';
                        $mail->Body    = "<h3>Hello {$data['username']},</h3><p>Your authentication code is: <strong style='font-size: 24px;'>{$authCode}</strong></p><p>This code expires in 10 minutes.</p>";

                        $mail->send();

                        // Temporarily store ID to verify on the next page
                        $_SESSION['pending_2fa_user_id'] = $data['id'];
                        header("Location: ../../public/verify_2fa.php"); 
                        exit();

                    } catch (Exception $e) {
                        $_SESSION['error'] = "Could not send 2FA email. Mailer Error: {$mail->ErrorInfo}";
                        header("Location: ../../public/login.php");
                        exit();
                    }
                }
                
                // --- STANDARD LOGIN (If 2FA is OFF) ---
                session_regenerate_id(true); 
                $_SESSION['user_id'] = $data['id']; 
                $_SESSION['userRole'] = $data['role'];
                $_SESSION['authUser'] = [
                    'user_id' => $data['id'],
                    'uuid' => $data['uuid'],
                    'username' => $data['username']
                ];

                if ($data['role'] === 'admin') {
                    $action = "Logged into the system";
                    $logQuery = "INSERT INTO `activity_logs` (`admin_id`, `action`) VALUES (?, ?)";
                    $logStmt = $conn->prepare($logQuery);
                    if ($logStmt) {
                        $logStmt->bind_param("is", $data['id'], $action); 
                        $logStmt->execute();
                        $logStmt->close();
                    }
                    header("Location: ../../public/admin/index.php");
                    exit();
                } else {
                    $visitQuery = "INSERT INTO `user_visits` (`user_id`) VALUES (?)";
                    $visitStmt = $conn->prepare($visitQuery);
                    if ($visitStmt) {
                        $visitStmt->bind_param("i", $data['id']);
                        $visitStmt->execute();
                        $visitStmt->close();
                    }
                    header("Location: ../../public/user/index.php");
                    exit();
                }

            } else {
                $_SESSION['error'] = "Invalid username or password.";
                header("Location: ../../public/login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: ../../public/login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Database error.";
        header("Location: ../../public/login.php");
        exit();
    }
}
?>