define(['jquery'], function ($) {
    "use strict";

    function openCrediteaModal(imageSrc) {
        $('#creditea-promo-modal').remove();

        var $modal = $('<div>', {
            id: 'creditea-promo-modal',
            css: {
                position: 'fixed',
                top: 0,
                left: 0,
                width: '100vw',
                height: '100vh',
                backgroundColor: 'rgba(0, 0, 0, 0.7)',
                zIndex: 9999,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                opacity: 0,
                transition: 'opacity 0.3s ease'
            }
        });

        var $inner = $('<div>', {
            class: 'creditea-promo-inner',
            css: {
                position: 'relative',
                backgroundSize: 'cover',
                maxWidth: '600px',
                minHeight: '400px',
                width: '90%',
                borderRadius: '8px'
            }
        });

        var $closeBtn = $('<button>', {
            class: 'creditea-promo-close',
            html: '&times;',
            css: {
                position: 'absolute',
                top: '0',
                right: '0',
                paddingRight: '10px',
                background: 'none',
                border: 'none',
                fontSize: '20px',
                cursor: 'pointer'
            }
        });

        var $image = $('<img>', {
            src: imageSrc,
            alt: 'Promo Image',
            css: {
                maxWidth: '100%',
                maxHeight: '100%',
                borderRadius: '8px'
            }
        });

        $inner.append($closeBtn).append($image);
        $modal.append($inner);
        $('body').append($modal);
        $modal.animate({ opacity: 1 }, 300);
        $modal.on('click', function () {
            $modal.animate({ opacity: 0 }, 300, function () {
                $modal.remove();
            });
        });

        $inner.on('click', function (e) {
            e.stopPropagation();
        });

        $closeBtn.on('click', function () {
            $modal.animate({ opacity: 0 }, 300, function () {
                $modal.remove();
            });
        });

        $(document).on('keydown.crediteaPromo', function (e) {
            if (e.key === 'Escape') {
                $modal.animate({ opacity: 0 }, 400, function () {
                    $modal.remove();
                });
                $(document).off('keydown.crediteaPromo');
            }
        });
    }

    $(document).on('click', '.creditea-promo-click', function (e) {
        e.preventDefault();
        var imageSrc = $(this).data('image');
        if (imageSrc) {
            openCrediteaModal(imageSrc);
        }
    });

    window.openCrediteaModal = openCrediteaModal;

    return {
        openCrediteaModal: openCrediteaModal
    };
});
