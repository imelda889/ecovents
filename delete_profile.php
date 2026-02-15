<?php
include "check.php";
include "connect.php";

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $delete_sql = "DELETE FROM organizer_user WHERE user_id='$user_id'";
    if (mysqli_query($dbConn, $delete_sql)) {
        session_unset();
        session_destroy();
        echo "<script>alert('Profile deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error deleting profile: " . mysqli_error($dbConn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .profile-container {
            padding: 40px 20px;
            max-width: 500px;
            margin: 0 auto;
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .warning-icon {
            width: 60px;
            height: 60px;
            background-color: #ffe6e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .warning-icon::before {
            content: "⚠";
            font-size: 32px;
            color: #c0392b;
        }

        .profile-card h2 {
            color: #c0392b;
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .warning-text {
            color: #333;
            font-size: 16px;
            margin-bottom: 10px;
            line-height: 1.6;
        }

        .warning-subtext {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .consequences-list {
            background-color: #fff5f5;
            border-left: 4px solid #c0392b;
            padding: 15px;
            margin: 20px 0;
            text-align: left;
            border-radius: 4px;
        }

        .consequences-list ul {
            margin: 10px 0;
            padding-left: 20px;
        }

        .consequences-list li {
            color: #666;
            font-size: 14px;
            margin: 8px 0;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            flex-direction: column-reverse;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-danger {
            background-color: #c0392b;
            color: white;
        }

        .btn-danger:hover {
            background-color: #a02b1f;
        }

        .btn-safe {
            background-color: #469c86;
            color: white;
        }

        .btn-safe:hover {
            background-color: #357a68;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 20px 15px;
            }

            .profile-card {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <?php include "header.php"; ?>

    <div class="profile-container">
        <div class="profile-card">
            <div class="warning-icon"></div>
            
            <h2>Delete Profile</h2>
            <p class="warning-text">Are you sure you want to delete your account?</p>
            <p class="warning-subtext">This action cannot be undone!</p>

            <div class="consequences-list">
                <strong>What will happen:</strong>
                <ul>
                    <li>Your account will be permanently deleted</li>
                    <li>All your events and data will be removed</li>
                    <li>You will be logged out immediately</li>
                    <li>You cannot recover your account after deletion</li>
                </ul>
            </div>

            <form method="POST" action="">
                <div class="button-group">
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Are you absolutely sure? This cannot be undone!')">
                        Yes, Delete My Profile
                    </button>
                    <a href="organizermainpage.php" class="btn btn-safe">
                        No, Keep My Account
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>