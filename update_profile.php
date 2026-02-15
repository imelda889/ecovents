<?php
include "check.php";
include "connect.php";

$user_id = $_SESSION['user_id'];

$sql = "SELECT name, email FROM organizer_user WHERE user_id = '$user_id'";
$result = mysqli_query($dbConn, $sql);
$user = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = mysqli_real_escape_string($dbConn, $_POST['name']);
    $email = mysqli_real_escape_string($dbConn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $update_fields = "name='$name', email='$email'";

    if (!empty($password) || !empty($confirm_password)) {
        if ($password !== $confirm_password) {
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $update_fields .= ", password='$hashed_password'";
        }
    }

    $update_sql = "UPDATE organizer_user SET $update_fields WHERE user_id='$user_id'";

    if (mysqli_query($dbConn, $update_sql)) {
        $_SESSION['user_name']  = $name;
        $_SESSION['user_email'] = $email;

        echo "<script>
            alert('Profile updated successfully!');
            window.location.href='organizermainpage.php';
        </script>";
    } else {
        echo "<script>alert('Error updating profile');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="img/test.png" type="images" />
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
        }

        .profile-card h2 {
            color: #024132;
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 24px;
        }

        .profile-card .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #024132;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #469c86;
        }

        .password-note {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
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

        .btn-primary {
            background-color: #469c86;
            color: white;
        }

        .btn-primary:hover {
            background-color: #357a68;
        }

        .btn-secondary {
            background-color: #e0e0e0;
            color: #333;
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 20px 15px;
            }

            .profile-card {
                padding: 20px;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<?php include "header.php"; ?>

<div class="profile-container">
    <div class="profile-card">
        <h2>Update Profile</h2>
        <p class="subtitle">Update your account information</p>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" id="name" name="name"
                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email"
                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" 
                       placeholder="Leave blank to keep current password">
                <p class="password-note">Only fill this if you want to change your password</p>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password"
                       placeholder="Confirm your new password">
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="organizermainpage.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>