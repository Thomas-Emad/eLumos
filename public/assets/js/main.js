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


function init() {
    animateScroll();
    counter();
}



export { init };
