<?php
include "../guestPage/connect.php";
include "../guestPage/check.php";

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM organizer_user WHERE user_id = $user_id";
$result = mysqli_query($dbConn, $sql);

if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
    $name = $user['name'];
    $password = $user['password'];
    $email = $user['email'];
    $profile_image = $user['profile_image'];
} else {
    $name = "";
    $password = "";
    $email = "";
    $profile_image = "../imagessssss/LOGO.png";
}

$message = "";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $new_name = mysqli_real_escape_string($dbConn, $_POST['name']);
    $new_password = mysqli_real_escape_string($dbConn, $_POST['password']);
    $new_email = mysqli_real_escape_string($dbConn, $_POST['email']);
    
    $update_sql = "UPDATE organizer_user SET name='$new_name', password='$new_password', email='$new_email' WHERE user_id=$user_id";
    
    if(mysqli_query($dbConn, $update_sql)){
        $message = "Profile updated successfully!";
        $name = $new_name;
        $password = $new_password;
        $email = $new_email;
    } else {
        $message = "Error updating profile!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - EcoVents</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
    <link rel="stylesheet" href="homep.css">
    
</head>
<body>
<?php include 'particNavigation.php';?>

    <div class="edit-profile-container">
        <a href="profile.php" class="back-btn">← Back to Profile</a>
        
        <h1 style="text-align: center;">Edit Profile</h1>

        <?php if($message): ?>
            <div style="padding: 12px; background: <?php echo strpos($message, 'success') !== false ? '#d4edda' : '#f8d7da'; ?>; color: <?php echo strpos($message, 'success') !== false ? '#155724' : '#721c24'; ?>; border-radius: 8px; margin-bottom: 20px; text-align: center; font-family: 'Tinos', serif;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="edit-form">
            <div class="profile-image-container">
                <img src="../uploads/LOGO.png" alt="Profile Image" class="profile-image">
            </div>


            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="name" value="<?php echo $name; ?>" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <div class="password-wrapper">
                    <input type="password" id="password-input" name="password" value="<?php echo $password; ?>" required>
                    <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                        <span id="eye-icon">👁️</span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <label>Email Address:</label>
                <input type="email" name="email" value="<?php echo $email; ?>" required>
            </div>

            <div class="profile-buttons">
                <button type="submit" class="profile-btn btn-save">Save Changes</button>
                <a href="profile.php">
                    <button type="button" class="profile-btn btn-logout">Discard</button>
                </a>
            </div>
        </form>
    </div>
<?php include 'particFooter.php';?>
</body>
</html>