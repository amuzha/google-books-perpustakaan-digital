(function ($) {
    "use strict";
    // CounterUp JS
    $(function () {
        $(".count").counterUp({
            delay: 5,
            time: 1000
        });
    });
    // Responsive Navigation JS
    $(".nav-mobile").click(function () {
        $(".nav-list").stop().slideUp(300);
        $(this).next(".nav-list").stop().slideToggle(300);
    });

    const selectHeader = document.querySelector('#header');
    if (selectHeader) {
        let headerOffset = selectHeader.offsetTop;

        const headerFixed = () => {
            if (window.scrollY > headerOffset) {
                selectHeader.classList.add('sticked');
            } else {
                selectHeader.classList.remove('sticked');
            }
        };

        window.addEventListener('load', headerFixed);
        document.addEventListener('scroll', debounce(headerFixed));
    }

    let navbarlinks = document.querySelectorAll('.main-navbar a');
    function navbarlinksActive() {
        navbarlinks.forEach(navbarlink => {
            if (!navbarlink.hash) return;
            let section = document.querySelector(navbarlink.hash);
            if (!section) return;

            let position = window.scrollY + 200;

            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                navbarlink.classList.add('active');
            } else {
                navbarlink.classList.remove('active');
            }
        });
    }

    // Debounce function to optimize scroll event handling
    function debounce(func, wait = 10, immediate = true) {
        let timeout;
        return function () {
            let context = this, args = arguments;
            let later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            let callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    }

    window.addEventListener('load', navbarlinksActive);
    document.addEventListener('scroll', debounce(navbarlinksActive));

    // FAQs JS
    $('.faq-accordion-heading').click(function (e) {
        e.preventDefault();
        if (!$(this).hasClass('active')) {
            $('.faq-accordion-heading').removeClass('active');
            $('.faq-accordion-content').slideUp(50);
            $(this).addClass('active');
            $(this).next('.faq-accordion-content').slideDown(50);
        } else if ($(this).hasClass('active')) {
            $(this).removeClass('active');
            $(this).next('.faq-accordion-content').slideUp(50);
        }
    });
}(jQuery));
