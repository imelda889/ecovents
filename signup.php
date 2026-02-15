<?php
session_start();
include "connect.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../library/PHPMailer/src/Exception.php';
require '../library/PHPMailer/src/PHPMailer.php';
require '../library/PHPMailer/src/SMTP.php';

if (isset($_POST['signsubmit'])) {

    $name = mysqli_real_escape_string($dbConn, $_POST['signname']);
    $email = mysqli_real_escape_string($dbConn, $_POST['signemail']);
    $password = mysqli_real_escape_string($dbConn, $_POST['signpassword']);
    $role = mysqli_real_escape_string($dbConn, $_POST['userRole']);
    $status = mysqli_real_escape_string($dbConn, $_POST['acc_status']);

    $stored_password = $password;

    $checkEmail = "SELECT * FROM organizer_user WHERE email = '$email'";
    $emailResult = mysqli_query($dbConn, $checkEmail);

    if (mysqli_num_rows($emailResult) > 0) {
        echo "<script>alert('Email already exists! Please use a different email.'); window.location.href='index.php';</script>";
        exit();
    }

    $roleName = "";
    if ($role == "organizer") {
        $roleName = "Organizer";
        $status = "Pending";
    } else if ($role == "participant") {
        $roleName = "Participant";
        $status = 'Approved';
    }

    $sql = "INSERT INTO organizer_user
    (password, name, email, role, google_id, profile_image, event_id, event_name, acc_status) 
    VALUES 
    ('$stored_password', '$name', '$email', '$roleName', '', 0, 0, '', '$status')";

    if (mysqli_query($dbConn, $sql)) {

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'company.ecovents@gmail.com';   
            $mail->Password = 'zhdi lhtn afjk famb'; 
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('company.ecovents@gmail.com', 'EcoVents');
            $mail->addAddress($email, $name);
            $mail->isHTML(true);

            if ($roleName === "Participant") {
                $mail->Subject = "Registration Successful";
                $mail->Body = "
                    <p>Dear $name,</p>
                    <p>Your registration for <strong>participant</strong> was successful. Welcome!</p>
                    <br><br><p>Best regards,<br>EcoVents Team</p>";
            } else {
                $mail->Subject = "Registration Pending Approval";
                $mail->Body = "
                    <p>Dear $name,</p>
                    <p>Your <strong>organizer</strong> account is pending admin approval.</p>
                    <br><br><p>Best regards,<br>EcoVents Team</p>";
            }
            $mail->send();

        } catch (Exception $e) {
        }
        $new_id = mysqli_insert_id($dbConn);
        $display_id = getDisplayID($new_id, $roleName);

        if ($roleName === "Organizer") {
            echo "<script>alert('Registration successful! Your ID is: $display_id\\n\\nYour organizer account is pending approval from admin.'); window.location.href='index.php';</script>";
            exit();
        } else {
            echo "<script>alert('Registration successful! Your ID is: $display_id'); window.location.href='index.php';</script>";
            exit();
        }

    } else {
        echo "<script>alert('Registration failed: " . mysqli_error($dbConn) . "'); window.location.href='index.php';</script>";
        exit();
    }
}

function getDisplayID($user_id, $role) {
    if ($role == "Admin") {
        $prefix = "AD";
    } else if ($role == "Organizer") {
        $prefix = "OR";
    } else {
        $prefix = "PA";
    }
    return $prefix . str_pad($user_id, 3, '0', STR_PAD_LEFT);
}
?>
