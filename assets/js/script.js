jQuery(document).ready(function($) {
    // Initialize the Slick slider on the posts container.
    var slider = $('.apg-posts-container').slick({
        infinite: true, 
        slidesToShow: 3, 
        slidesToScroll: 1, 
        dots: false, 
        arrows: false, 
        responsive: [
            {
                breakpoint: 1024, // Adjust settings for screens 1024px and below.
                settings: {
                    slidesToShow: 2, 
                    slidesToScroll: 1 
                }
            },
            {
                breakpoint: 600, // Adjust settings for screens 600px and below.
                settings: {
                    slidesToShow: 1, 
                    slidesToScroll: 1 
                }
            }
        ]
    });

    // Attach click event handlers for custom previous/next buttons.
    $('.apg-slider-prev').click(function() {
        slider.slick('slickPrev');
    });

    $('.apg-slider-next').click(function() {
        slider.slick('slickNext');
    });

    // Update the progress bar width based on the current slide.
    slider.on('init reInit afterChange', function(event, slick, currentSlide) {
        var i = (currentSlide ? currentSlide : 0) + 1;
        var percent = (i / slick.slideCount) * 100;
        $('.progress-bar').css('width', percent + '%');
    });

    // Function to equalize the heights of slides in the slider.
    function equalizeSliderHeights(sliderSelector) {
        $(sliderSelector).on('setPosition', function() {
            // Reset the height of all slides.
            $(this).find('.slick-slide').height('auto');
            
            // Find the max height among all slides.
            var maxHeight = 0;
            $(this).find('.slick-slide').each(function() {
                if ($(this).height() > maxHeight) { maxHeight = $(this).height(); }
            });

            // Set the height of all slides to the max height found.
            $(this).find('.slick-slide').height(maxHeight);
        });
    }

    equalizeSliderHeights('.apg-posts-container');
});
