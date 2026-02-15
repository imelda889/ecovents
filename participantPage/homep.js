// ===== NAVBAR & MOBILE MENU =====
const navbar = document.getElementById("navbar");
window.addEventListener("scroll", () => {
    navbar.classList.toggle("scrolled", window.scrollY > 50);
});

const hamburger = document.getElementById("hamburger");
const mobileMenu = document.getElementById("mobileMenu");

hamburger.onclick = () => {
    mobileMenu.classList.toggle("active");
    hamburger.classList.toggle("active");
};

// Mobile dropdown toggle
document.querySelectorAll('.mobile-dropdown .dropdown-toggle').forEach(toggle => {
    toggle.addEventListener('click', function(e) {
        e.preventDefault();
        this.parentElement.classList.toggle('active');
    });
});


function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password-input');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = '👁️';
            }
        }
// ===== SCROLL FUNCTIONS =====
function scrollBadges(direction) {
    const container = document.getElementById('badgesScroll');
    if (container) {
        container.scrollBy({ left: direction * 100, behavior: 'smooth' });
    }
}

function scrollQuickAccess(direction) {
    const container = document.getElementById('quickAccessScroll');
    if (container) {
        container.scrollBy({ left: direction * 150, behavior: 'smooth' });
    }
}

// ===== SCROLL REVEAL =====
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
        }
    });
});
document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

function confirmRegister() {
    return confirm("Do you want to register for this event?");
}

document.addEventListener('DOMContentLoaded', function() {
    var dropdown = document.getElementById('eventFilter');
    
    if (dropdown) {
        dropdown.addEventListener('change', function() {
            var filter = this.value;
            var allEvents = document.querySelectorAll('.event-box');
            
            for (var i = 0; i < allEvents.length; i++) {
                var eventBox = allEvents[i];
                
                if (filter === 'all') {
                    eventBox.style.display = '';
                } else if (eventBox.classList.contains(filter)) {
                    eventBox.style.display = '';
                } else {
                    eventBox.style.display = 'none';
                }
            }
        });
    }
});

document.getElementById('pastFilter').addEventListener('change', function() {
    const container = document.querySelector('.event-container');
    const cards = Array.from(container.querySelectorAll('.event-card'));
    
    if (this.value === 'latest') {
        cards.sort((a, b) => new Date(b.dataset.date) - new Date(a.dataset.date));
    } else if (this.value === 'oldest') {
        cards.sort((a, b) => new Date(a.dataset.date) - new Date(b.dataset.date));
    }
    
    container.innerHTML = '';
    cards.forEach(card => container.appendChild(card));
});
function openFeedback(eventID) {
    document.getElementById("event_id").value = eventID;
    document.getElementById("feedbackBox").style.display = "block";
}

function closeFeedback() {
    document.getElementById("feedbackBox").style.display = "none";
}