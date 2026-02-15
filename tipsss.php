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

</head>
<body>
<?php include 'guestNavigation.php';?>
<section class="hero-contact">
    <img src="../imagessssss/recycle2.jpg" alt="recycle">
</section>
<section class="contact">
    <h1 font-size: 60px>Small Actions, Big Impact</h1>
    <p letter-spsacing: 1px>Explore our curated collection of simple, effective sustainability tips you can start today.</p>
</section>
<section class="tips-section">
    <div class="tips-container">

        <?php
        include "connect.php";

        $sql = "SELECT news_title, news_content, news_link 
                FROM news 
                WHERE news_type = 'tips'";

        $result = mysqli_query($dbConn, $sql);

        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
        ?>
            <div class="tip-card">
                <h4><?php echo $row['news_title']; ?></h4>

                <p>
                    <?php 
                        echo substr($row['news_content'], 0, 120); 
                    ?>...
                </p>

                <a href="<?php echo $row['news_link']; ?>" target="_blank" class="read-more">
                    Read More →
                </a>
            </div>
        <?php
            }
        } else {
            echo "<p>No tips available.</p>";
        }
        ?>

    </div>
</section>

<?php include 'guestFooter.php';?>
</body>
</html>