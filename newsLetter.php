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
    body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    }

    .news-section {
        flex: 1;
        width: 90%;
        max-width: 1000px;
        margin: 20px auto;
    }
    .news-section h1 {
        font-family: 'Playfair Display', serif;
    }
    .search-box {
        text-align: right;
        margin-bottom: 20px;
    }

    .search-box input[type="text"] {
        padding: 7px;
        width: 220px;
    }

    .search-box input[type="submit"],
    .search-box button {
        padding: 7px 12px;
        cursor: pointer;
    }
    .news-box {
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 15px;
        border-radius: 6px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        line-height: 1.6;
    }

    .news-box h3 {
        margin-top: 0;
        font-size: 18px;
        font-family: 'Arial', sans-serif;
    }

    .news-box p {
        font-family: 'Arial', sans-serif;
    }
    .read-link {
        font-size: 14px;
        font-weight: 600;
        color: #2f7d32;
        text-decoration: none;
    }

    .read-link:hover {
        color: #1b5e20;
        text-decoration: underline;
    }
</style>
</head>
<body>
<?php include 'guestNavigation.php';?>
<section class="news-section">
    <div>
        <h1 class="all-events-title">Latest News</h1>
    <div class="search-box">
    <form action="" method="get">
        <input type="text" name="search_key" placeholder="Search news">
        <input type="submit" value="Search">
        <a href="newsLetter.php">
            <button type="button">Show All</button>
        </a>
    </form>
</div>

<?php
include "../guestPage/connect.php";
$search_key = isset($_GET['search_key']) ? $_GET['search_key'] : "";

$sql = "SELECT * FROM news WHERE news_type = 'news'";

if ($search_key != "") {
    $sql .= " AND news_title LIKE '%$search_key%'";
}

$result = mysqli_query($dbConn, $sql);

if (mysqli_num_rows($result) <= 0) {
    echo "<p>No news found.</p>";
} else {
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <div class="news-box">
            <h3><?php echo $row['news_title']; ?></h3>
            <p><?php echo $row['news_content']; ?></p>
            <br>
            <a class="read-link" href="<?php echo $row['news_link']; ?>" target="_blank">
                Read Full Article
            </a>
        </div>
        <?php
    }
}
?>
</section>

<?php include 'guestFooter.php';?>
</body>
</html>