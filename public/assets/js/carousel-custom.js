$(document).ready(function() {
    // Initialize carousel with custom settings
    $('#adsCarousel').carousel({
        interval: 5000, // Time between slides (5 seconds)
        pause: "hover",
        wrap: true
    });

    // Add custom transition animation
    $('#adsCarousel').on('slide.bs.carousel', function(e) {
        var $activeItem = $(e.relatedTarget);
        var $items = $activeItem.parent().children();
        
        // Apply custom animation
        $activeItem.css({
            'animation': 'slideAnimation 5.5s ease forwards'
        });

        // Remove animation class from other items
        $items.not($activeItem).css({
            'animation': 'none'
        });
    });

    // Optional: Add touch swipe support using jQuery UI
    if ($.fn.swipe) {
        $("#adsCarousel").swipe({
            swipe: function(event, direction) {
                if (direction === 'left') {
                    $(this).carousel('next');
                }
                if (direction === 'right') {
                    $(this).carousel('prev');
                }
            },
            allowPageScroll: "vertical"
        });
    }
}); 