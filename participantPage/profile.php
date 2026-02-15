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
    $display_id = $_SESSION['display_id'];
} else {
    $name = "User";
    $password = "";
    $email = "";
    $profile_image = "../imagessssss/LOGO.png";
    $display_id = "";
}

$masked_password = str_repeat('*', strlen($password));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EcoVents</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
    <link rel="stylesheet" href="homep.css">
</head>
<body>
<?php include 'particNavigation.php';?>

    <div class="profile-container">
        <h1>My Profile</h1>

        <div class="profile-image-container">
            <img src="../uploads/LOGO.png" alt="Profile Image" class="profile-image">
        </div>

        <div class="profile-info">
            <div class="info-row">
                <div class="info-label">User ID:</div>
                <div class="info-value"><?php echo $display_id; ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Full Name:</div>
                <div class="info-value"><?php echo $name; ?></div>
            </div>

            <div class="info-row">
                <div class="info-label">Password:</div>
                <div class="info-value" style="display: flex; align-items: center; gap: 10px;">
                    <span id="password-text"><?php echo $masked_password; ?></span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-label">Email Address:</div>
                <div class="info-value"><?php echo $email; ?></div>
            </div>
        </div>

        <div class="profile-buttons">
            <a href="edit_profile.php">
                <button class="profile-btn btn-edit">Edit Profile</button>
            </a>

            <a href="delete_confirm.php">
                <button class="profile-btn btn-delete">Delete Account</button>
            </a>

            <a href="../guestPage/Logout.php">
                <button class="profile-btn btn-logout">Log Out</button>
            </a>
        </div>
    </div>

<?php include 'particFooter.php';?>
</body>
</html>