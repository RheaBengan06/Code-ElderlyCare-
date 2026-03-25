<?php
require __DIR__ . '/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include('conn.php');
session_start();






if (isset($_POST['sendCode'])) {
    $email = trim($_POST['email']);

    $stmt = $conn->prepare("SELECT * FROM caregivers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $code = strval(rand(100000, 999999));
        $expiry = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $update = $conn->prepare("UPDATE caregivers SET reset_code = ?, reset_expiry = ? WHERE email = ?");
        $update->bind_param("sss", $code, $expiry, $email);
        $update->execute();

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['EMAIL_USER'];
            $mail->Password   = $_ENV['EMAIL_PASS'];
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom($_ENV['EMAIL_USER'], 'ElderlyCare System');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Password Reset Code';
            $mail->Body    = "
                <p>Hello,</p>
                <p>You requested a password reset. Your verification code is:</p>
                <h2>$code</h2>
                <p>This code will expire in 15 minutes.</p>
                <br><p>– ElderlyCare System</p>
            ";

            $mail->send();

           echo "<script>
                    alert('Reset code sent to your email.');
                    window.location.href = 'verify_code.php?email=" . urlencode($email) . "';
                </script>";
                    exit();

       } catch (Exception $e) {
        echo "<script>
            alert('Mailer Error: " . $mail->ErrorInfo . "');
            window.location.href = 'forgot_password.php';
        </script>";
        exit();
    }
} else {
    echo "<script>
        alert('No caregiver account found with that email.');
        window.location.href = 'forgot_password.php';
    </script>";
    exit();
}
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_code'])) {
    $code = trim($_POST['reset_code']);

    $stmt = $conn->prepare("SELECT email, reset_expiry FROM caregivers WHERE reset_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

         if (strtotime($row['reset_expiry']) < time()) {
        echo "<script>
            alert('Reset code has expired.');
            window.location.href = 'verify_code.php';
        </script>";
        exit();
    }

    $_SESSION['reset_email'] = $row['email'];
    echo "<script>
        alert('Code verified successfully.');
        window.location.href = 'change_password.php?email=" . urlencode($row['email']) . "';
    </script>";
    exit();
} else {
    echo "<script>
        alert('Invalid or expired code.');
        window.location.href = 'verify_code.php';
    </script>";
    exit();
}
}



if (isset($_POST['submitPass'])) {
    $newpassword = $_POST['new_password'];
    $confirmpassword = $_POST['confirm_password'];


    $email = isset($_GET['email']) ? $_GET['email'] : (isset($_SESSION['reset_email']) ? $_SESSION['reset_email'] : '');

    if (empty($email)) {
        echo "<script>alert('Email not found'); window.location.href='forgot_password.php';</script>";
        exit;
    }

    if ($newpassword !== $confirmpassword) {
        echo "<script>alert('Passwords do not match'); window.location.href='change_password.php?email=" . urlencode($email) . "';</script>";
        exit;
    }

    $newHashed = password_hash($newpassword, PASSWORD_BCRYPT);

    $stmt = $conn->prepare("SELECT id FROM caregivers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($caregiver_id);

    if ($stmt->fetch()) {
        $stmt->close();

        $updateStmt = $conn->prepare("UPDATE caregivers SET password = ?, reset_code = NULL, reset_expiry = NULL WHERE id = ?");
        $updateStmt->bind_param("si", $newHashed, $caregiver_id);

        if ($updateStmt->execute()) {
            echo "<script>alert('Password changed successfully'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Failed to update password'); window.location.href='change_password.php?email=" . urlencode($email) . "';</script>";
            exit;
        }
    } else {
        $stmt->close();
        echo "<script>alert('Email not found'); window.location.href='forgot_password.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('Invalid access'); window.location.href='forgot_password.php';</script>";
    exit;
}

?>