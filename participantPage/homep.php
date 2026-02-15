<?php
include "../guestPage/connect.php";
include "../guestPage/check.php";

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM organizer_user WHERE user_id = $user_id";
$result = mysqli_query($dbConn, $sql);

if(mysqli_num_rows($result) > 0){
    $user = mysqli_fetch_assoc($result);
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

$events_sql = "SELECT * FROM event LIMIT 3";
$events_result = mysqli_query($dbConn, $events_sql);

$reward_sql = "SELECT * FROM reward LIMIT 2";
$reward_result = mysqli_query($dbConn, $reward_sql);

$ann_sql = "SELECT * FROM news WHERE news_type = 'announcement' ORDER BY news_created_at DESC LIMIT 2";
$ann_result = mysqli_query($dbConn, $ann_sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Home - EcoVents</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&family=Lora:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
<link rel="icon" href="../imagessssss/LOGO.png" type="image/png">
<link rel="stylesheet" href="homep.css">
</head>

<body>
<?php include 'particNavigation.php';?>

<!-- Hero Section -->
<header class="hero-section">
    <img src="../imagessssss/views.jpg" alt="Welcome" class="hero-bg">
    <div class="hero-content">
        <h2>Welcome Back,</h2>
        <h1><?php echo $name; ?></h1>
    </div>
</header>

<!-- Main Content -->
<main class="main-content">
    <div class="dashboard-top">
        <!-- Eco Points Section -->
        <section class="eco-points-card">
            <h3>Eco Points</h3>
            <div class="points-display">
                <div class="points-icon">
                    <img src="../imagessssss/points.png" alt="Points">
                </div>
                <div class="points-info">
                    <span class="points-number"><?php echo $points; ?> <small>pts</small></span>
                </div>
            </div>
        </section>

        <section class="badges-section">
            <h3><a href="achievements.php">Recent Badges</a></h3>
            <div class="badges-container">
                <div class="badges-scroll" id="badgesScroll">
                    <div class="badge-item">
                        <a href="achievements.php">
                        <img src="../imagessssss/badge1.png" alt="Badge" onerror="this.style.background='var(--lightest-green)'">
                        <span>Eco Starter</span>
                        </a>
                    </div>
                    <div class="badge-item">
                        <a href="achievements.php">
                        <img src="../imagessssss/badge2.png" alt="Badge" onerror="this.style.background='var(--lightest-green)'">
                        <span>Green Hero</span>
                        </a>
                    </div>
                    <div class="badge-item">
                        <a href="achievements.php">
                        <img src="../imagessssss/badge3.png" alt="Badge" onerror="this.style.background='var(--lightest-green)'">
                        <span>Earth Guardian</span>
                        </a>
                    </div>
                    <div class="badge-item">
                        <a href="achievements.php">
                        <img src="../imagessssss/badge4.png" alt="Badge" onerror="this.style.background='var(--lightest-green)'">
                        <span>Green Ambassador</span>
                        </a>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <section class="quick-access-section">
        <h3>Quick Access</h3>
        <div class="quick-access-container">
            <button class="scroll-btn scroll-left" onclick="scrollQuickAccess(-1)">‹</button>
            <div class="quick-access-scroll" id="quickAccessScroll">
                <a href="allE.php" class="quick-card">
                    <span>Discover Events</span>
                </a>
                <a href="achievements.php" class="quick-card">
                    <span>Achievements</span>
                </a>
                <a href="rewards.php" class="quick-card">
                    <span>Rewards</span>
                </a>
                <a href="leaderB.php" class="quick-card">
                    <span>Leaderboard</span>
                </a>
            </div>
            <button class="scroll-btn scroll-right" onclick="scrollQuickAccess(1)">›</button>
        </div>
    </section>

    <div class="dashboard-bottom">
    <section class="rewards-section">
        <h3><a href="rewards.php">Rewards</a></h3>

        <div class="rewards-list">
            <?php 
            if ($reward_result && mysqli_num_rows($reward_result) > 0) {
                while ($reward = mysqli_fetch_assoc($reward_result)) { 
            ?>
                <div class="reward-item">
                    <div class="reward-info">
                        <span class="reward-name">
                            <?php echo $reward['reward_name']; ?>
                        </span>
                        <span class="reward-points">
                            <?php echo $reward['pointsRequired']; ?> pts
                        </span>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>No rewards found.</p>";
            }
            ?>
        </div>
    </section>
    </div>

    <section class="announcement-section">
        <div class="announcement-header">
            <h3>Announcements</h3>
        </div class="annnounce-list">
        <div>
            <?php 
            if ($ann_result && mysqli_num_rows($ann_result) > 0) {
                while ($announcement = mysqli_fetch_assoc($ann_result)) { 
                    $created_at = date("d M, Y", strtotime($announcement['news_created_at']));
            ?>
                <div class="announcement-item">
                    <div class="announcement-info">
                        <span class="announcement-title">
                            <?php echo $announcement['news_title']; ?>
                        </span>
                        <span class="announcement-date">
                            📅 <?php echo $created_at; ?>
                        </span>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "<p>No announcements found.</p>";
            }
            ?>
        </div>
    </section>

    <section class="recommended-section">
        <div class="section-header">
            <h3>Recommended For You</h3>
            <a href="allE.php" class="view-more">View More</a>
        </div>

        <div class="events-list">

            <?php
            if ($events_result && mysqli_num_rows($events_result) > 0) {
                while ($event = mysqli_fetch_assoc($events_result)) {
                    $startdate = date("d M, Y", strtotime($event['start_date']));
                    $enddate = date("d M, Y", strtotime($event['end_date']));
            ?>
            <div class="event-card">
                <div class="event-img">
                    <img src="../guestPage/img/<?php echo $event['image']?>" alt="Event">
                    <span class="event-category">
                        <?php echo $event['event_type']; ?>
                    </span>
                </div>

                <div class="event-recommen">
                    <h4><?php echo $event['event_name']; ?></h4>
                    <p class="event-date">📅 <?php echo $startdate . " - " . $enddate; ?></p>
                    <p class="event-locations">📍 <?php echo $event['location']; ?></p>
                </div>
            </div>
            <?php
                }
            } else {
                echo "<p>No events found.</p>";
            }
            ?>

        </div>
    </section>

    </div>
</main>

<?php include 'particFooter.php';?>
</body>
</html>