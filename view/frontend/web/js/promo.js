define([
    'jquery',
    'domReady!'
], function($) {
    var crediteaPromo = document.querySelector('.creditea-checkout-promo');
    var sidebar = document.querySelector('aside.opc-sidebar');

    if (crediteaPromo && sidebar) {
        sidebar.appendChild(crediteaPromo);
    }
});
