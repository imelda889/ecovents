<?php
session_start();
include "../guestPage/connect.php";

if (!isset($_SESSION['user_id'])) {
    die("<script>alert('Please login first.'); window.location.href='../guestPage/index.php';</script>");
}

if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
    die("<script>alert('Invalid event.'); window.history.back();</script>");
}

$user_id  = (int) $_SESSION['user_id'];
$event_id = (int) $_POST['event_id']; 

$date   = date("Y-m-d H:i:s");
$status = "pending";

$checkSql = "SELECT * FROM registration
             WHERE user_id = $user_id AND eventID = $event_id";
$checkResult = mysqli_query($dbConn, $checkSql);

if (mysqli_num_rows($checkResult) > 0) {
    die("<script>alert('You have already registered for this event.'); window.history.back();</script>");
}

$sql = "INSERT INTO registration (user_id, eventID, registration_date, registration_status)
        VALUES ($user_id, $event_id, '$date', '$status')";

if (mysqli_query($dbConn, $sql)) {
    echo "<script>alert('Registration successful! Status: Pending'); window.location.href='allE.php';</script>";
} else {
    die("SQL Error: " . mysqli_error($dbConn));
}
?>
