(function () {
    'use strict';

    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var navigation = document.querySelector('.navbar-custom');

    if (navigation) {
        var updateNavigation = function () {
            navigation.classList.toggle('navbar-scrolled', window.scrollY > 18);
        };

        updateNavigation();
        window.addEventListener('scroll', updateNavigation, { passive: true });
    }

    var revealTargets = document.querySelectorAll(
        '[data-reveal], main > section:not(.hero):not(.patient-hero):not(.patient-subhero), main > .container > section, body > section:not(.hero):not(.patient-hero):not(.patient-subhero)'
    );

    if (reduceMotion || !('IntersectionObserver' in window)) {
        revealTargets.forEach(function (element) {
            element.classList.add('is-revealed');
        });
        return;
    }

    var observer = new IntersectionObserver(function (entries, currentObserver) {
        entries.forEach(function (entry) {
            if (!entry.isIntersecting) {
                return;
            }

            entry.target.classList.add('is-revealed');
            currentObserver.unobserve(entry.target);
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -48px' });

    revealTargets.forEach(function (element) {
        if (!element.hasAttribute('data-aos')) {
            element.classList.add('scroll-reveal');
        }
        observer.observe(element);
    });
})();
