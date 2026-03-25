<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) session_start();
include 'conn.php';

if (isset($_POST['create'])) {
   
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $contact_phone = $_POST['contact_phone'];
    $address = $_POST['address'];
    $certification_number = $_POST['certification_number'] ?? null;
    $experience = $_POST['experience'];
    $specialized_skills = $_POST['specialized_skills'] ?? null;
    $availability = $_POST['availability'];
    $preferred_hours = $_POST['preferred_hours'] ?? null;
    $emergency_contact_name = $_POST['emergency_contact_name'];
    $emergency_contact_phone = $_POST['emergency_contact_phone'];
    $background_check = isset($_POST['background_check']) ? 1 : 0;
    $health_check = isset($_POST['health_check']) ? 1 : 0;

    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.'); window.location='templates/register.php';</script>";
        exit;
    }

    $check = "SELECT id FROM caregivers WHERE email = ?";
    $stmt = mysqli_prepare($conn, $check);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        echo "<script>alert('Email already registered.'); window.location='templates/caregiver/userLogin.php';</script>";
        exit;
    }
    mysqli_stmt_close($stmt);

    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO caregivers (email, password, status) VALUES (?, ?, 'Pending')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $hashed);

    if (!mysqli_stmt_execute($stmt)) {
        echo "Error executing query: " . mysqli_error($conn);
        exit;
    }

    $caregiver_id = mysqli_insert_id($conn);
    $info_sql = "INSERT INTO caregivers_info (caregiver_id, full_name, dob, gender, contact_phone, address,
         certification_number, experience, specialized_skills, availability,
         preferred_hours, emergency_contact_name, emergency_contact_phone,
         background_check, health_check)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $info_stmt = mysqli_prepare($conn, $info_sql);
    mysqli_stmt_bind_param(
        $info_stmt,
        "issssssissssiii",
        $caregiver_id,
        $full_name,
        $dob,
        $gender,
        $contact_phone,
        $address,
        $certification_number,
        $experience,
        $specialized_skills,
        $availability,
        $preferred_hours,
        $emergency_contact_name,
        $emergency_contact_phone,
        $background_check,
        $health_check
    );
    mysqli_stmt_execute($info_stmt);
    mysqli_stmt_close($info_stmt);

    $msg = "New caregiver “{$full_name}” needs approval.";
    $n = mysqli_prepare($conn, "INSERT INTO admin_notifications (type, reference_id, message)
       VALUES ('new_caregiver', ?, ?)");
    mysqli_stmt_bind_param($n, "is", $caregiver_id, $msg);
    mysqli_stmt_execute($n);
    mysqli_stmt_close($n);

    echo "<script>
            alert('Registered! Awaiting admin approval.');
            window.location='templates/caregiver/userLogin.php';
          </script>";
    exit;
}


if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

 
    $sql = "SELECT c.*, ci.full_name 
            FROM caregivers c
            LEFT JOIN caregivers_info ci ON c.id = ci.caregiver_id
            WHERE c.email = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if (!$user = mysqli_fetch_assoc($res)) {
        $_SESSION['message'] = "No account found with that email.";
        header("Location: templates/caregiver/userLogin.php");
        exit;
    }

    if ($user['status'] !== 'Approved') {
        $_SESSION['message'] = "Your account is not yet approved.";
        header("Location: templates/caregiver/userLogin.php");
        exit;
    }

    if (!password_verify($password, $user['password'])) {
        $_SESSION['message'] = "Incorrect password.";
        header("Location: templates/caregiver/userLogin.php");
        exit;
    }

    // Login successful
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['message'] = "Login successful! Welcome back, " . $user['full_name'] . "!";
    header("Location: templates/caregiver/CaregiverDashboard.php");
    exit;
}


?>

