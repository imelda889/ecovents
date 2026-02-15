<?php
    include "../guestPage/connect.php";
    include "../guestPage/check.php";

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM organizer_user WHERE user_id = $user_id";
    $result = mysqli_query($dbConn, $sql);

    if(mysqli_num_rows($result) > 0){
        $user = mysqli_fetch_assoc($result);
        $name = $user['name'];
        $profile_image = $user['profile_image'];
        $display_id = $_SESSION['display_id'];
    } else {
        $name = "User";
        $profile_image = "";
        $display_id = "";
    }

    $sql = "SELECT eventID, event_name, event_type, description, start_date, end_date, start_time, end_time, earns_point, registration_deadlines, participant_categories, event_cost, location, status FROM event WHERE status = 'Approved' ORDER BY start_date ASC"; 
    $result = mysqli_query($dbConn, $sql);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About Us - EcoVents</title>

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
    <img src="../imagessssss/green grass.jpg" alt="About Us">
</section>

<section class="about-us-section">
    <h1>Why We Exist</h1>
    <p class="subtitle">We are here to turn awareness into action</p>
</section>

<section class="what-we-do">

    <div class="grid">

        <div class="box image-box">
            <img src="../imagessssss/recy.jpg" alt="">
        </div>

        <div class="box text-box">
            <h4>Tree Planting</h4>
            <p>Contribute to cleaner air and increased greenery.</p>
        </div>

        <div class="box image-box">
            <img src="../imagessssss/low.jpg" alt="">
        </div>

        <div class="box text-box">
            <h4>Clean-Up and Recycling</h4>
            <p>Reduce waste and prevent pollution.</p>
        </div>

        <div class="box image-box">
            <img src="../imagessssss/treeplanting.jpg" alt="">
        </div>
        
        <div class="box text-box">
            <h4>Low-Carbon Campaigns</h4>
            <p>Encourage eco-friendly habits to reduce CO₂ emissions.</p>
        </div>

    </div>
</section>

<section class="mission-section">
    <div class="mission">
        <div class="circle">Mission</div>
        <p>To encourage sustainable actions by connecting people with meaningful environmental events and initiatives.</p>
    </div>
    <br>
    <div class="mission">
        <div class="circle">Vision</div>
        <p>To build a greener future where communities actively participate in protecting the environment.</p>
    </div>
    <br>
    <div class="mission">
        <div class="circle">Values</div>
        <p>Community participation, environmental responsibility, transparency, and positive impact through action.</p>
    </div>
</section>

<section class="about-bottom">
    <div class="about-image">
        <img src="../imagessssss/leaves.jpg" alt="About EcoVents">
    </div>

    <div class="about-text">
        <h3>We are taking small steps to make Earth a better place</h3>

        <ul>
            <li>Preserve nature</li>
            <li>Reduce environmental harm</li>
            <li>Inspire sustainable action</li>
        </ul>
        <br><br><br>
        <a href="allE.php" class="btn">Explore</a>
    </div>
</section>

<?php include 'particFooter.php';?>
</body>
</html>
