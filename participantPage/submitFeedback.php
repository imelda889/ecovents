<?php
session_start();
include "../guestPage/connect.php";

$user_id  = $_SESSION['user_id'];
$event_id = $_POST['event_id'];
$comment  = $_POST['feedback'];

$sql = "UPDATE registration
        SET feedback = '$comment',
            submitted_at = NOW()
        WHERE user_id = $user_id
        AND eventID = $event_id";

mysqli_query($dbConn, $sql);

echo "<script>alert('Feedback is submitted successfully');
      window.location.href = 'MyPast.php';
</script>";

exit;
?>