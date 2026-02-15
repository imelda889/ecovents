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

    $rewsql = "SELECT * FROM reward";
    $rewardResult = mysqli_query($dbConn, $rewsql);

    $minesql = "SELECT r.reward_name, r.pointsRequired FROM user_reward ur JOIN reward r ON ur.reward_id = r.reward_id WHERE ur.user_id=$user_id";
    $myRes = mysqli_query($dbConn, $minesql);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Rewards - EcoVents</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
<link rel="stylesheet" href="homep.css">
</head>

<body>

<?php include 'particNavigation.php';?>
<section class="reward-section">
    <div class="reward-wrapper">
        <h2 class="currentPoints">Current Points: <?php echo $user['points']?></h2>
    <h1 class="explore">Explore</h1>
    <br><br>
    <div class="reward-box">
    <?php while ($r = mysqli_fetch_assoc($rewardResult)) {

        $reward_id = $r['reward_id'];
        $check = mysqli_query($dbConn,
            "SELECT * FROM user_reward
            WHERE user_id=$user_id AND reward_id=$reward_id");
        $claimed = mysqli_num_rows($check) > 0;
    ?>
    <div class="reward-card">
        <p><strong><?php echo $r['reward_name']; ?></strong></p>
        <p font-size: 12px><?php echo $r['pointsRequired']; ?> points</p>
        <br>
        <?php if ($claimed) { ?>
            <button disabled>Redeemed</button>
        <?php } elseif ($points >= $r['pointsRequired']) { ?>
            <form method="post" action="redeemReward.php">
                <input type="hidden" name="reward_id" value="<?php echo $reward_id; ?>">
                <button>Redeem</button>
            </form>
        <?php } else { ?>
            <button disabled>Not enough points</button>
        <?php } ?>
    </div>
    <?php } ?>
    </div>
    <br><br>

    <h2>My Rewards</h2>
    <br>
    <div class="my-reward">
    <?php while ($m = mysqli_fetch_assoc($myRes)) { ?>
        <div class="my-reward-item">
            <?php echo $m['reward_name']; ?><br>
            <?php echo $m['pointsRequired']; ?> pts
        </div>
    <?php } ?>
    </div>
    </div>
</section>

<?php include 'particFooter.php';?>
</body>
</html>
