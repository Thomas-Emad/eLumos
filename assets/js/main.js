/*  Show, Hide Menu */
const toggle_menu = document.getElementsByClassName('show-nav')[0],
    nav = document.getElementById('nav-menu')

toggle_menu.addEventListener('click', () => {
    nav.classList.toggle('show')
})


document.addEventListener('DOMContentLoaded', function () {
    // Show And hidden Scroll top button
    const scrollTop = document.querySelector('.scroll-top');
    const scrollTopButton = () => {
        if (window.scrollY > 150) {
            scrollTop.style.display = 'inline-block';
        } else {
            scrollTop.style.display = 'none';
        }
    };
    // Scroll to top functionality
    const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    };
    scrollTop.addEventListener('click', scrollToTop);

    // Trigger animation on load
    const animateSections = document.querySelectorAll('.an-section');

    const animateOnScroll = () => {
        animateSections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= window.innerHeight && rect.bottom >= 0) {
                section.classList.add('visible');
            }
        });
    };

    // Trigger counter on load
    const animateCounters = document.querySelectorAll('.counter-target');

    const animateCounterScroll = () => {
        animateCounters.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= window.innerHeight && rect.bottom >= 0 && !section.classList.contains('end')) {
                section.classList.add('end'); // Ensure counter only animates once
                const target = Number(section.getAttribute('data-target'));
                let current = 0;
                const increment = target / 100; // Adjust the divisor to control the speed of the counter

                let interval = setInterval(() => {
                    current += increment;
                    section.innerText = Math.round(current);
                    if (current >= target) {
                        section.innerText = target;
                        clearInterval(interval);
                    }
                }, 50);
            }
        });
    };


    // Run functions on scroll
    window.addEventListener('scroll', () => {
        animateOnScroll();
        animateCounterScroll();
        scrollTopButton();
    });

    animateOnScroll();
    animateCounterScroll();
    scrollTopButton();

});
