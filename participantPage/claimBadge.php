<?php
include "../guestPage/check.php";
include "../guestPage/connect.php";

$user_id = $_SESSION['user_id'];
$badge_id = $_POST['badge_id'];

$sql = "INSERT INTO user_badge (user_id, badge_id)
        VALUES ($user_id, $badge_id)";

mysqli_query($dbConn, $sql);

echo "<script>alert('Badge claimed!'); window.location.href='achievements.php';</script>";
?>
