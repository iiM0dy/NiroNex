/*
Template Name: CryptoLand - Crypto Currency Landing Page Template.
Author: GrayGrids
*/

(function () {
    //===== Prealoder

    window.onload = function () {
        window.setTimeout(fadeout, 500);
    }

    function fadeout() {
        var pl = document.querySelector('.preloader'); if(pl) pl.style.opacity = '0';
        var pl = document.querySelector('.preloader'); if(pl) pl.style.display = 'none';
    }


    /*=====================================
    Sticky
    ======================================= */
    window.onscroll = function () {
        // var header_navbar = document.querySelector(".navbar-area");
        // var sticky = header_navbar.offsetTop;

        // var defaultLogo = document.querySelector(".default-logo");
        // var stickyLogo = document.querySelector(".sticky-logo");

        // if (window.pageYOffset > sticky) {
        //     header_navbar.classList.add("sticky");
        //     defaultLogo.classList.add("d-none");
        //     stickyLogo.classList.remove("d-none");
        // } else {
        //     header_navbar.classList.remove("sticky");
        //     defaultLogo.classList.remove("d-none");
        //     stickyLogo.classList.add("d-none");
        // }
        // show or hide the back-to-top button
        var backToTo = document.querySelector(".scroll-top");
        if (backToTo) {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                backToTo.classList.add("show");
            } else {
                backToTo.classList.remove("show");
            }
        }
    };

    // Smooth Scroll to Top
    var backToTo = document.querySelector(".scroll-top");
    if (backToTo) {
        backToTo.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            // Lose focus to prevent "stuck" hover state on some browsers
            this.blur();
        });
    }

    // WOW active
    new WOW().init();

    //===== mobile-menu-btn
    let navbarToggler = document.querySelector(".mobile-menu-btn");
    navbarToggler.addEventListener('click', function () {
        navbarToggler.classList.toggle("active");
    });


})();