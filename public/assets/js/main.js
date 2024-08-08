// Trigger animation on load
function animateScroll() {
    const animateSections = document.querySelectorAll('.an-section');

    const animateOnScroll = () => {
        animateSections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= window.innerHeight && rect.bottom >= 0) {
                setTimeout(() => {
                    section.classList.add('visible');
                }, 500);
            }
        });
    };

    const isContentSmallerThanViewport = document.body.scrollHeight <= window.innerHeight;

    if (isContentSmallerThanViewport) {
        animateSections.forEach(section => {
            section.classList.add('visible');
        });
    } else {
        // Initial check in case some sections are already in view
        animateOnScroll();
        window.addEventListener('scroll', animateOnScroll);
    }
}


// Trigger counter on load
function counter() {
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
    animateCounterScroll()
    window.addEventListener('scroll', animateCounterScroll);
}
counter()

function modeView() {
    var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
    var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

    // Change the icons inside the button based on previous settings
    if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        themeToggleLightIcon.classList.remove('hidden');
    } else {
        themeToggleDarkIcon.classList.remove('hidden');
    }

    var themeToggleBtn = document.getElementById('theme-toggle');

    themeToggleBtn.addEventListener('click', function () {

        // toggle icons inside button
        themeToggleDarkIcon.classList.toggle('hidden');
        themeToggleLightIcon.classList.toggle('hidden');

        // if set via local storage previously
        if (localStorage.getItem('color-theme')) {
            if (localStorage.getItem('color-theme') === 'light') {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            }

            // if NOT set via local storage previously
        } else {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
            }
        }
    });
}

// Loader
function loader() {
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.querySelector("#loader");
        loader.className += " hidden";
    })
}


function init() {
    animateScroll();
    counter();
    modeView();
    loader();
}



export { init };
