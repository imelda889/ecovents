<?php
session_start();
include "connect.php";

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

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($dbConn, trim($_POST['email']));
    $password = trim($_POST['password']);
    
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please enter both email and password'); window.location.href='index.php';</script>";
        exit();
    }

    $sql = "SELECT * FROM organizer_user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($dbConn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        
        $storedPassword = $row['password'];
        $passwordMatch = false;
        
        if (substr($storedPassword, 0, 4) === '$2y$') {
            $passwordMatch = password_verify($password, $storedPassword);
        } else {
            $passwordMatch = ($password === $storedPassword);
        }
        
        if ($passwordMatch) {
            $display_id = getDisplayID($row['user_id'], $row['role']);
            
            $_SESSION['user_id'] = $row['user_id'];        
            $_SESSION['display_id'] = $display_id;          
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];
            $_SESSION['profile_image'] = $row['profile_image'];
            
            if ($row['role'] == 'Admin') {
                header("Location: mainpage.php");
                exit();
            } 
            else if ($row['role'] == 'Organizer') {
                header("Location: organizermainpage.php");
                exit();
            } 
            else if ($row['role'] == 'Participant') {
                header("Location: ../participantPage/homep.php");
                exit();
            } 
            else {
                echo "<script>alert('Invalid role'); window.location.href='index.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid email or password'); window.location.href='index.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='index.php';</script>";
    }
}
?>