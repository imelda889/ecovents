<nav id="navbar">
    <div class="nav-container">
        <a href="homep.php" class="logo-container">
            <img src="../imagessssss/LOGO.png" class="logo-image">
            <div class="logo-text">
                <span class="brand-name">ECOVENTS</span>
                <span class="tagline">BREATHE GREEN</span>
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="homep.php" class="active">Home</a></li>
            <li class="nav-dropdown">
                <a>Events</a>
                <ul class="dropdown-menu">
                    <li><a href="allE.php">All Events</a></li>
                    <li><a href="eventMap.php">Event Map</a></li>
                    <li><a href="eventRanking.php">Event Ranking</a></li>
                </ul>
            </li>
            <li class="nav-dropdown">
                <a>My Journey</a>
                <ul class="dropdown-menu">
                    <li><a href="MyPast.php">My Past Events</a></li>
                    <li><a href="achievements.php">Achievements</a></li>
                    <li><a href="rewards.php">Rewards</a></li>
                </ul>
            </li>
            <li class="nav-dropdown">
                <a>Explore</a>
                <ul class="dropdown-menu">
                    <li><a href="newS.php">News</a></li>
                    <li><a href="sustainntips.php">Tips</a></li>
                    <li><a href="leaderB.php">Leaderboard</a></li>
                </ul>
            </li>
            <li class="nav-dropdown">
                <a>More</a>
                <ul class="dropdown-menu">
                    <li><a href="ecoTalkWall.php">EcoTalk Wall</a></li>
                    <li><a href="aboutUs.php">About Us</a></li>
                    <li><a href="contactUs.php">Contact Us</a></li>
                </ul>
            </li>
        </ul>

        <div class="nav-profile">
            <a href="profile.php" class="profile-link">
                <span class="profile-greeting">Hello, <?php echo $name; ?></span>
                <div class="profile-avatar">
                    <?php if($profile_image && $profile_image != '0'): ?>
                        <img src="<?php echo $profile_image; ?>" alt="Profile">
                    <?php else: ?>
                        <span><?php echo strtoupper(substr($name, 0, 1)); ?></span>
                    <?php endif; ?>
                </div>
            </a>
        </div>

        <div class="hamburger" id="hamburger">
            <span></span><span></span><span></span>
        </div>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-profile">
            <div class="profile-avatar">
                <?php if($profile_image && $profile_image != '0'): ?>
                    <img src="<?php echo $profile_image; ?>" alt="Profile">
                <?php else: ?>
                    <span><?php echo strtoupper(substr($name, 0, 1)); ?></span>
                <?php endif; ?>
            </div>
            <span>Hello, <?php echo $name; ?></span>
        </div>
        <ul>
            <li><a href="homep.php">Home</a></li>
            <li class="mobile-dropdown">
                <a class="dropdown-toggle">Events</a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="allE.php">All Events</a></li>
                    <li><a href="eventRanking.php">Event Ranking</a></li>
                    <li><a href="eventMap.php">Event Map</a></li>
                </ul>
            </li>
            <li class="mobile-dropdown">
                <a class="dropdown-toggle">Explore</a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="newS.php">News</a></li>
                    <li><a href="sustainntips.php">Sustainability Tips</a></li>
                    <li><a href="leaderB.php">Leaderboard</a></li>
                </ul>
            </li>
            <li class="mobile-dropdown">
                <a class="dropdown-toggle">My Journey</a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="MyPast.php">My Past Events</a></li>
                    <li><a href="achievements.php">Achievements</a></li>
                    <li><a href="rewards.php">Rewards</a></li>
                </ul>
            </li>
            <li class="mobile-dropdown">
                <a class="dropdown-toggle">More</a>
                <ul class="mobile-dropdown-menu">
                    <li><a href="ecoTalkWall.php">EcoTalk Wall</a></li>
                    <li><a href="aboutUs.php">About Us</a></li>
                    <li><a href="contactUs.php">Contact Us</a></li>
                </ul>
            </li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="../guestPage/Logout.php" class="logout-link">Logout</a></li>
        </ul>
    </div>
</nav>
