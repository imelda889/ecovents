<?php
    include "../guestPage/connect.php";
    include "../guestPage/check.php";

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM organizer_user WHERE user_id = $user_id";
    $userResult = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($userResult) > 0){
        $user = mysqli_fetch_assoc($userResult);
        $name = $user['name'];
        $profile_image = $user['profile_image'];
        $display_id = $_SESSION['display_id'];
    } else {
        $name = "User";
        $profile_image = "";
        $display_id = "";
    }

    $sql = "SELECT eventID, event_name, event_type, description, start_date, end_date, start_time, end_time, earns_point, registration_deadlines, participant_categories, image, event_cost, location, status FROM event WHERE status = 'approve' ORDER BY start_date ASC"; 
    $eventResult = mysqli_query($dbConn, $sql);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us - EcoVents</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
<link rel="stylesheet" href="homep.css">
</head>

<body>
<?php include 'particNavigation.php';?>

<section class="hero-contact">
    <img src="../imagessssss/welcome.jpg" alt="Contact Us">
</section>

<section class="contact">
    <h1>Get In Touch</h1>
    <p class="subtitle">
        We would love to hear from you. Reach out for questions, feedback, or collaborations.
    </p>

    <div class="contact-info">
        <p>📞 +6012-389 1567</p>
        <p><a href="mailto:company.ecovents@gmail.com">📧 company.ecovents@gmail.com</a></p>
        <p>🌐 ecovents.com</p>
    </div>
</section>

    
</section>
<?php include 'particFooter.php';?>
</body>
</html>
