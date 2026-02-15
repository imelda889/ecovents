<?php
include "check.php";
include "connect.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email FROM organizer_user WHERE user_id = '$user_id'";
$result = mysqli_query($dbConn, $sql);
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
    <style>
        body {
            background-color: #f5f5f5;
        }

        .profile-container {
            padding: 40px 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h1 {
            color: #024132;
            margin: 0 0 10px 0;
            font-size: 32px;
        }

        .profile-header p {
            color: #666;
            font-size: 16px;
            margin: 0;
        }

        .profile-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .profile-avatar {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-avatar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid #469c86;
            object-fit: cover;
        }

        .profile-info-section {
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #024132;
            min-width: 120px;
            font-size: 14px;
        }

        .info-value {
            color: #333;
            font-size: 14px;
            word-break: break-word;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
            display: inline-block;
        }

        .btn-primary {
            background-color: #469c86;
            color: white;
        }

        .btn-primary:hover {
            background-color: #357a68;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(70,156,134,0.3);
        }

        .btn-danger {
            background-color: #ffffff;
            color: #c0392b;
            border: 2px solid #c0392b;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(192,57,43,0.3);
        }

        .btn-back {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e0e0e0;
            color: #333;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-back:hover {
            background-color: #d0d0d0;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 20px 15px;
            }

            .profile-card {
                padding: 25px 20px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-label {
                min-width: auto;
            }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="profile-container">
    <a href="organizermainpage.php" class="btn-back">← Back to Dashboard</a>

    <div class="profile-header">
        <h1>My Profile</h1>
        <p>View and manage your account information</p>
    </div>

    <div class="profile-card">
        <div class="profile-avatar">
            <img src="img/user.png" alt="Profile Avatar">
        </div>

        <div class="profile-info-section">
            <div class="info-row">
                <div class="info-label">Name:</div>
                <div class="info-value"><?php echo htmlspecialchars($user['name']); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
            </div>
            <div class="info-row">
                <div class="info-label">Account Type:</div>
                <div class="info-value">Event Organizer</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="update_profile.php" class="btn btn-primary">
                Update Profile
            </a>
            <a href="delete_profile.php" class="btn btn-danger">
                Delete Account
            </a>
        </div>
    </div>
</div>

</body>
</html>