$(function () {

    $('.js-carousel').each(function () {
        initCarousel($(this));
    });

    function initCarousel($carousel) {
        const $track = $carousel.find('.js-carousel-track');
        const $dots = $carousel.find('.js-carousel-dot');
        const slideCount = $dots.length || 1;
        const autoplayDelay = parseInt($carousel.data('autoplay')) || 4000;

        let current = 0;
        let timer = null;

        function goTo(index) {
            current = (index + slideCount) % slideCount;
            $track.css('transform', `translateX(-${current * (100 / slideCount)}%)`);

            $dots.removeClass('bg-white w-4').addClass('bg-white/50');
            $dots.eq(current).removeClass('bg-white/50').addClass('bg-white w-4');
        }

        function next() { goTo(current + 1); }
        function prev() { goTo(current - 1); }

        function startAutoplay() {
            stopAutoplay();
            if (slideCount > 1) {
                timer = setInterval(next, autoplayDelay);
            }
        }

        function stopAutoplay() {
            if (timer) clearInterval(timer);
        }

        // Manual controls
        $carousel.find('.js-carousel-next').on('click', function (e) {
            e.preventDefault();
            next();
            startAutoplay(); // reset timer after manual interaction
        });

        $carousel.find('.js-carousel-prev').on('click', function (e) {
            e.preventDefault();
            prev();
            startAutoplay();
        });

        // Pause on hover, resume on leave
        $carousel.on('mouseenter', stopAutoplay);
        $carousel.on('mouseleave', startAutoplay);

        startAutoplay();
    }

});