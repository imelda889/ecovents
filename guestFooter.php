<footer class="eco-footer">
    <div class="footer-main">
        <div class="footer-container">
            <div class="footer-column">
                <h4>Events</h4>
                <ul class="footer-links">
                    <li><a href="allEvents.php">All Events</a></li>
                    <li><a href="ranking.php">Event Ranking</a></li>
                    <li><a href="eventMap.php">Event Map</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>Explore</h4>
                <ul class="footer-links">
                    <li><a href="newsLetter.php">News</a></li>
                    <li><a href="tipsss.php">Sustainability Tips</a></li>
                    <li><a href="leaderBoard.php">Leaderboard</a></li>
                </ul>
            </div>
            
            <div class="footer-column">
                <h4>More</h4>
                <ul class="footer-links">
                    <li><a href="ecoTalkWall.php">EcoTalk Wall</a></li>
                    <li><a href="aboutUs.php">About Us</a></li>
                    <li><a href="contactus.php">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column footer-newsletter">
                <div class="footer-brand">
                    <div class="brand-icon">
                        <img src="../imagessssss/LOGO.png" alt="EcoVents Logo">
                    </div>
                    <span>EcoVents</span>
                </div>
                
                <div class="footer-contact-info">
                    <p>📍 <a href="https://share.google/eG8eGUbZSZh9mvSAm">Jalan Teknologi 5, Taman Teknologi Malaysia, 57000 Kuala Lumpur</a></p>
                    <p>📩 <a href="mailto:company.ecovents@gmail.com">company.ecovents@gmail.com</a></p>
                    <p>📞 +6012-389 1567</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <div class="footer-bottom-container">
            <p class="copyright">Copyright © 2026 EcoVents. All rights reserved.</p>
        </div>
    </div>
</footer>

<div class="login-box" id="loginbox">
    <div class="modal-card">
        <button class="modal-close-btn" onclick="closebox()">&times;</button>
        <div class="modal-header">
            <h2>Login</h2>
            <p>Fill in your information below</p>
        </div>
        <div class="modal-body">
            <form method="post" action="Login.php" autocomplete="off">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input id="email" type="email" name="email" placeholder="Enter your email" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <div class="password-wrapper">
                        <input id="password" type="password" name="password" placeholder="Enter your password" autocomplete="off" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password')">Show</button>
                    </div>
                </div>
                <button class="modal-submit-btn" type="submit" name="submit">Login</button>
                <div class="modal-footer">
                    Don't have an account? <a href="#" onclick="closebox(); openSignbox();">Sign Up</a>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="signup-box" id="signupbox">
    <div class="modal-card">
        <button class="modal-close-btn" onclick="closebox()">&times;</button>
        <div class="modal-header">
            <h2>Sign Up</h2>
            <p>Fill in your information below</p>
        </div>
        <div class="modal-body">
            <form method="post" action="signup.php">
                <div class="form-group">
                    <label for="signname">Name:</label>
                    <input id="signname" type="text" name="signname" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="signemail">Email:</label>
                    <input id="signemail" type="email" name="signemail" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="signpassword">Password:</label>
                    <div class="password-wrapper">
                        <input id="signpassword" type="password" name="signpassword" placeholder="Create a password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('signpassword')">Show</button>
                    </div>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="form-group role-selection">
                    <label>Register as:</label>
                    <div class="role-options">
                        <label class="role-radio">
                            <input type="radio" name="userRole" value="participant" required>
                            <span>Participant</span>
                        </label>
                        <label class="role-radio">
                            <input type="radio" name="userRole" value="organizer" required>
                            <span>Organizer</span>
                        </label>
                    </div>
                </div>
                <div class="form-group checkbox-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required>
                        <span>Agree with Terms and Conditions</span>
                    </label>
                </div>
                <button class="modal-submit-btn" type="submit" name="signsubmit">Sign Up</button>
                <div class="modal-footer">
                    Already have an account? <a href="#" onclick="closebox(); openbox();">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>
 
<script src="homepage.js"></script>
