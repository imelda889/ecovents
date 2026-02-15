<?php
include "../guestPage/connect.php";
include "../guestPage/check.php";

$user_id = $_SESSION['user_id'];

if(isset($_POST['confirm_delete'])){
    $delete_sql = "DELETE FROM organizer_user WHERE user_id = $user_id";
    
    if(mysqli_query($dbConn, $delete_sql)){
        session_destroy();
        header("Location: ../guestPage/index.php");
        exit();
    }
}

if(isset($_POST['cancel'])){
    header("Location: profile.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account - EcoVents</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    <link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
    <link rel="stylesheet" href="homep.css">
</head>
<body>
    <div class="noise-overlay"></div>

    <div class="modal-overlay">
        <div class="modal-content">
            <h2>Confirm to delete your account permanently?</h2>
            
            <form method="POST">
                <div class="modal-buttons">
                    <button type="submit" name="confirm_delete" class="profile-btn btn-delete">Delete</button>
                    <button type="submit" name="cancel" class="profile-btn btn-logout">No</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>