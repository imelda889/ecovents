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
        $points = $user['points'];
    } else {
        $name = "User";
        $profile_image = "";
        $display_id = "";
        $points = 0;
    }

    $sql = "SELECT * FROM badge";
    $result = mysqli_query($dbConn, $sql);    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Achievements - EcoVents</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
<link rel="stylesheet" href="homep.css">
</head>

<body>

<?php include 'particNavigation.php';?>

<center>
<section class="achievements-section">
    <br>
    <h1 class="page-title">My Achievements</h1>
    <br><br>
    <h3><?php echo $name; ?>'s Eco-Points</h3>
    <br>
    <h1><?php echo $points; ?> pts</h1>
    <br><br><br>
    
    <hr>
    <div class="badge-container">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {

            $badge_id = $row['badge_id'];

            $checkSql = "SELECT * FROM user_badge 
                        WHERE user_id = $user_id AND badge_id = $badge_id";
            $checkRes = mysqli_query($dbConn, $checkSql);
            $claimed = mysqli_num_rows($checkRes) > 0;
        ?>

        <div class="badge-card">

            <img src="<?php echo $row['badge_icon']; ?>" class="badge-icon">

            <h4><?php echo $row['badge_name']; ?></h4>

            <p>Required: <?php echo $row['requiredPoints']; ?> pts</p>
            <br>
            <?php if ($claimed) { ?>
                <span class="badge-done"><strong>Completed</strong></span>
            <?php } elseif ($points >= $row['requiredPoints']) { ?>
                <form method="post" action="claimBadge.php">
                    <input type="hidden" name="badge_id" value="<?php echo $badge_id; ?>">
                    <button class="claim-btn">Claim</button>
                </form>
            <?php } else { ?>
                <span class="badge-lock">Locked</span>
            <?php } ?>

        </div>
        <?php } ?>
</div>
</section>
</center>

<?php include 'particFooter.php';?>
</body>
</html>
