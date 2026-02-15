
<header>
    <button class="menu-toggle" onclick="toggleMenu()" aria-label="Toggle menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
    
    <div class="logo" style="display:inline-block;">
        <a href="organizermainpage.php"><img src="img/logo.png" alt="website logo"></a>
    </div>

    <nav id="mainNav">
        <ul>
            <li><a href="organizermainpage.php"><img src="img/dashboard.png" alt="dashboard icon">DASHBOARD</a></li>
            <li><a href="createevent.php"><img src="img/createevent.png" alt="create event icon">CREATE EVENT</a></li>
            <li><a href="participant.php"><img src="img/participant.png" alt="participant icon">PARTICIPANT</a></li>
            <li><a href="analytic.php"><img src="img/analytics.png" alt="analytics icon">ANALYTICS & REPORTS</a></li>
            <li><a href="event_calendar.php"><img src="img/calendar.png" alt="calendar icon">VIEW CALENDAR</a></li>
        </ul>
    </nav>
    
    <div class="user-section">
        <a href="profile.php" class="user-profile">
            <img src="img/user.png" alt="User Avatar">
            <span class="username">
                <?php 
                echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'Organizer'; 
                ?>
            </span>
        </a>

        <a href="Logout.php" class="logout-btn">Logout</a>
    </div>
</header>

<script>
    function toggleMenu() {
        const nav = document.getElementById('mainNav');
        const toggle = document.querySelector('.menu-toggle');
        nav.classList.toggle('active');
        toggle.classList.toggle('active');
    }
    
    function confirmLogout() {
        return confirm('Are you sure you want to logout?');
    }
    
    document.addEventListener('click', function(event) {
        const nav = document.getElementById('mainNav');
        const toggle = document.querySelector('.menu-toggle');
        const header = document.querySelector('header');
        
        if (window.innerWidth <= 768 && !header.contains(event.target)) {
            nav.classList.remove('active');
            toggle.classList.remove('active');
        }
    });
    
    document.querySelectorAll('nav a').forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                const nav = document.getElementById('mainNav');
                const toggle = document.querySelector('.menu-toggle');
                nav.classList.remove('active');
                toggle.classList.remove('active');
            }
        });
    });
</script>