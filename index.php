
<?php
    include "connect.php";

    $sql = "SELECT event_name, image FROM event WHERE status='approved' ORDER BY eventID DESC LIMIT 10";
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

</head>
<body>
<header class="hero-slider">
    <div class="hero-slider-container">

        <div class="hero-slider-item active">
            <img src="../imagessssss/plant.jpg" alt="joinus" class="hero-slide">

            <div class="hero-slide-text">
                <h2>Plant Your Journey</h2>
                <p>Participate in challenges, track your impact, and find your community.</p>

                <div class="hero-buttons">
                    <button class="hero-btn primary" onclick="openSignbox()">
                        Join Us Now
                    </button>
                </div>
            </div>
        </div>

    </div>
</header>

<?php include 'guestNavigation.php';?>
<!-- What We Do -->
<section class="mission-section">
    <div class="mission-container">
        <div class="mission-header">
            <span class="mission-subtitle">WHAT WE DO</span>
            <h2>Together for a Greener Future</h2>
            <p>We bridge the gap between good intentions and real-world impact. Our platform helps people get involved, stay motivated, and see the impact of their efforts.</p>
        </div>
        
        <div class="mission-cards">
            <div class="mission-card">
                <h3>Our Mission</h3>
                <p>To encourage sustainable actions by connecting people with meaningful environmental events and initiatives.</p>
            </div>
            <div class="mission-card">
                <h3>Our Vision</h3>
                <p>A future where communities actively participate in protecting and improving the environment together.</p>
            </div>
            <div class="mission-card">
                <h3>Our Values</h3>
                <p>We value community participation, environmental responsibility, transparency, and positive impact through action.</p>
            </div>
        </div>
        
        <div class="mission-footer">
            <a href="aboutUs.php" class="btn-underline-dark">About Us</a>
        </div>
    </div>
</section>

<!-- Event Highlights -->
<section class="highlights-section">
    <div class="highlights-container">
        <h2 class="highlights-title">Event Highlights</h2>
        <p class="highlights-subtitle">Discover meaningful ways to make an impact</p>
        
        <button class="slider-arrow prev" onclick="slideHighlights('prev')">‹</button>
        <button class="slider-arrow next" onclick="slideHighlights('next')">›</button>
        
        <div class="highlights-list" id="highlightsList">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="highlight-item">
                    <div class="highlight-img-wrapper">
                        <img src="img/<?php echo ($row['image']); ?>" alt="<?php echo ($row['event_name']); ?>">
                    </div>
                    <div class="highlight-info">
                        <h3><?php echo ($row['event_name']); ?></h3>
                        <a href="allEvents.php" class="view-event-link">View Event</a>
                    </div>
                </div>
            <?php
                }
            } else {
                echo '<p style="text-align: center; color: #666;">No events available</p>';
            }
            ?>
        </div>

        <div class="highlights-footer">
            <button class="btn-outline"><a href="allEvents.php" class="highlights-footer">Explore All Events</a></button>
        </div>
    </div>
</section>

<!-- Environmental Impact-->
<section class="impact-section">
    <div class="impact-container">
        <div class="impact-header">
            <h2>Environmental Impact</h2>
            <p class="impact-subtitle">Together, we're making a real difference</p>
        </div>
        
        <div class="impact-gallery">
            <div class="impact-gallery-item">
                <img src="../imagessssss/leaves.jpg" alt="Tropical Leaves">
            </div>
            <div class="impact-gallery-item">
                <img src="../imagessssss/soil.jpg" alt="Hands Holding Plant">
            </div>
            <div class="impact-gallery-item">
                <img src="../imagessssss/impact1.jpg" alt="Seed">
            </div>
            <div class="impact-gallery-item">
                <img src="../imagessssss/green grass.jpg" alt="Green Leaves">
            </div>
        </div>
        
        <div class="impact-stats-grid">
            <div class="impact-stat-card">
                <span class="impact-number">400+</span>
                <span class="impact-label">Active Users</span>
            </div>
            
            <div class="impact-stat-card">
                <span class="impact-number">1600</span>
                <span class="impact-label">kg Waste Reduced</span>
            </div>
            
            <div class="impact-stat-card">
                <span class="impact-number">5500</span>
                <span class="impact-label">kg CO₂ Reduced</span>
            </div>
            
            <div class="impact-stat-card">
                <span class="impact-number">480</span>
                <span class="impact-label">Trees Planted</span>
            </div>
            
            <div class="impact-stat-card featured">
                <span class="impact-number">353</span>
                <span class="impact-label">Events Completed</span>
            </div>
        </div>
    </div>
</section>

<section class="hero-section">
    <div class="hero-grid">
        <div class="hero-content">
            <h1 id="heroText">Ready to change the world ? <br><span>Join Us Now</span></h1>
            <a href="#" class="btn-main" id="heroBtn" onclick="openSignbox()">Start Your Journey</a>
        </div>
        <div class="image-arch-wrapper" id="heroImg">
            <img src="../imagessssss/homepagehero.jpg" alt="joinusimg">
        </div>

    </div>
</section>

<?php include 'guestFooter.php';?></body>
</html>