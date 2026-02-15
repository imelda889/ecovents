<?php
include "../guestPage/check.php";
include "../guestPage/connect.php";

$user_id = $_SESSION['user_id'];
$reward_id = $_POST['reward_id'];

$rq = mysqli_query($dbConn,
    "SELECT pointsRequired FROM reward WHERE reward_id=$reward_id");
$r = mysqli_fetch_assoc($rq);
$cost = $r['pointsRequired'];

mysqli_query($dbConn,
    "UPDATE organizer_user
     SET points = points - $cost
     WHERE user_id=$user_id");

mysqli_query($dbConn,
    "INSERT INTO user_reward (user_id, reward_id, reward_claimed_at)
     VALUES ($user_id, $reward_id, NOW())");

echo "<script>window.location.href='rewards.php';</script>";
