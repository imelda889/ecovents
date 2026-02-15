<?php
include "../guestPage/connect.php";

$comment = $_POST['message'];

$sql = "INSERT INTO anonymous_wall (comment_text) VALUES ('$comment')";
mysqli_query($dbConn, $sql);

echo "<script>
alert('Comment added successfully');
window.location.href='ecoTalkWall.php';
</script>";
?>
