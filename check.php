<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // Not logged in, go to homepage
   die("<script>alert('Please login first before proceed!');window.location.href='index.php';</script>");
}
?>
