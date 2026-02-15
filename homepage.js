const navbar = document.getElementById("navbar");
window.addEventListener("scroll", () => {
    navbar.classList.toggle("scrolled", window.scrollY > 50);
});

const hamburger = document.getElementById("hamburger");
const mobileMenu = document.getElementById("mobileMenu");

hamburger.onclick = () => {
    mobileMenu.classList.toggle("active");
};

function slideHighlights(direction) {
    const list = document.getElementById('highlightsList');
    const scrollAmount = 290;
    
    if (direction === 'next') {
        list.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    } else {
        list.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    }
}

function openbox(){
    document.getElementById('loginbox').classList.add('active');
    document.body.style.overflow = 'hidden';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
}
function openSignbox(){
    document.getElementById('signupbox').classList.add('active');
    document.body.style.overflow = 'hidden';
    document.getElementById('signname').value = '';
    document.getElementById('signemail').value = '';
    document.getElementById('signpassword').value = '';
    var radioButtons = document.querySelectorAll('input[name="userRole"]');
    radioButtons.forEach(function(radio) {
        radio.checked = false;
    });
    var termsCheckbox = document.querySelector('input[name="terms"]');
    if (termsCheckbox) termsCheckbox.checked = false;
}
function closebox(){
    document.getElementById('loginbox').classList.remove('active');
    document.getElementById('signupbox').classList.remove('active');
    document.body.style.overflow = 'auto';
}
document.getElementById('loginbox').addEventListener('click', function(e){
    if(e.target === this){
        closebox();
    }
});

document.getElementById('signupbox').addEventListener('click', function(e){
    if(e.target === this){
        closebox();
    }
});

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.textContent = 'Hide';
    } else {
        input.type = 'password';
        button.textContent = 'Show';
    }
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