define(['jquery'], function ($) {
    "use strict";

    console.log('creditea-promo-venobox.js loaded');

    $.fn.extend({
        crediteaPromoModal: function () {
            this.on('click', function (e) {
                e.preventDefault();

                // Usuń istniejący modal
                $('#creditea-promo-modal').remove();

                // Pobierz dynamiczny src z atrybutu data-image
                var imageSrc = $(this).data('image');

                // Tworzymy modal
                var $modal = $(`
                    <div id="creditea-promo-modal" style="
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100vw;
                        height: 100vh;
                        background-color: rgba(0, 0, 0, 0.7);
                        z-index: 9999;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    ">
                        <div class="creditea-promo-inner" style="
                            position: relative;
                            background: url('${imageSrc}') no-repeat center center;
                            background-size: cover;
                            max-width: 600px;
                            min-height: 400px;
                            width: 90%;
                            border-radius: 8px;
                        ">
                            <button class="creditea-promo-close" style="
                                position: absolute;
                                top: 0px;
                                right: 0px;
                                padding-right: 10px;
                                background: none;
                                border: none;
                                font-size: 20px;
                                cursor: pointer;
                            ">&times;</button>
                            <img src="${imageSrc}" alt="Promo Image" style="
                                max-width: 100%;
                                max-height: 100%;
                                border-radius: 8px;
                            " />
                        </div>
                    </div>
                `);

                $('body').append($modal);

                // Kliknięcie w tło zamyka modal
                $modal.on('click', function () {
                    $modal.remove();
                });

                // Kliknięcie wewnątrz (kontener z obrazem) NIE zamyka modalu
                $modal.find('.creditea-promo-inner').on('click', function (e) {
                    e.stopPropagation();
                });

                // Zamknięcie modalu przy kliknięciu przycisku X
                $modal.find('.creditea-promo-close').on('click', function () {
                    $modal.remove();
                });

                // Opcjonalnie: ESC też zamyka modal
                $(document).on('keydown.crediteaPromo', function (e) {
                    if (e.key === 'Escape') {
                        $modal.remove();
                        $(document).off('keydown.crediteaPromo');
                    }
                });
            });

            return this;
        }
    });

    $(document).ready(function () {
        $('.creditea-promo-click').crediteaPromoModal();
    });
});
