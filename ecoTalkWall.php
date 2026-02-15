<?php
include "connect.php";
$sql = "SELECT * FROM anonymous_wall ORDER BY created_at DESC";
$result = mysqli_query($dbConn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>EcoVents - Breathe Green</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Story+Script&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png" sizes="280x280">
<link rel="stylesheet" href="homepage.css">

<style>
.wall-container {
    width: 90%;
    margin: 20px auto;
    column-count: 2;
    column-gap: 20px;
}

.comment-box {
    background: white;
    padding: 15px;
    border-radius: 12px;
    margin-bottom: 20px;
    display: inline-block;
    width: 100%;
}

.anonymous {
    font-weight: bold;
    color: #555;
    margin-bottom: 8px;
}

.add-box {
    background: white;
    padding: 15px;
    border-radius: 12px;
    width: 90%;
    margin: 20px auto;
}

textarea {
    width: 100%;
    height: 80px;
}

button {
    margin-top: 10px;
    padding: 8px 15px;
}
</style>

</head>
<body>

<?php include 'guestNavigation.php';?>
<section class="ecotalk-section">
    <center>
    <div class="ecotalk-container">
        <h1 class="ecotalk-title">EcoTalk Wall</h1>
        <p>Your voice matters - leave a suggestion anonymously.</p>
    </div><br>
    <div>
        <form method="post" action="addComment.php">
            <textarea name="message" id="message" placeholder="Type your comment here..." required="requierd"></textarea>
            <br>
            <button type="submit">Send</button>
        </form>
    </div>

    <div class="wall-container">
    <?php
    while($row = mysqli_fetch_assoc($result)){
    ?>
        <div class="comment-box">
            <div class="anonymous">Anonymous</div>
            <div><?php echo nl2br($row['comment_text']); ?></div>
        </div>
    <?php } ?>
    </div>

    <br><br><br>
    <p style="text-align:center; font-size:12px;">
    All submissions are anonymous.
    </p>
    </center>
</section>

<?php include 'guestFooter.php';?>
</body>
</html>