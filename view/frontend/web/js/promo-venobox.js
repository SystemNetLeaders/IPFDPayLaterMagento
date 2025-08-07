
require(['jquery'], function($) {
    $(document).ready(function() {
        $('.creditea-modal-trigger').on('click', function() {
            $('#creditea-modal').fadeIn();
        });

        $('.creditea-modal-close').on('click', function() {
            $('#creditea-modal').fadeOut();
        });

        $(window).on('click', function(e) {
            if ($(e.target).is('#creditea-modal')) {
                $('#creditea-modal').fadeOut();
            }
        });
    });
});