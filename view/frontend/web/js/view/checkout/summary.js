define([
    'uiComponent',
    'mage/url',
    'Magento_Checkout/js/model/quote',
    'ko',
    'jquery'
], function (Component, urlBuilder, quote, ko, $) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Creditea_Magento2/checkout/summary',
            bannerUrls: {},
            enabledPositions: {}
        },

        initialize: function () {
            this._super();

            // mapy pozycji -> observables
            this.bannerUrls = {};
            this.enabledPositions = {};

            this.loadBannerData('promo_modal_content');
            this.loadBannerData('checkout_below_summary');
            return this;
        },

        ensureObservables: function (position) {
            if (!this.bannerUrls[position]) {
                this.bannerUrls[position] = ko.observable('');
            }
            if (!this.enabledPositions[position]) {
                this.enabledPositions[position] = ko.observable(false);
            }
        },

        loadBannerData: function (position) {
            var self = this;
            self.ensureObservables(position);

            var requestUrl = urlBuilder.build('creditea/banner/geturl?position=' + position);

            fetch(requestUrl, { method: 'GET', cache: 'no-store' })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(function (data) {
                    if (data.isEnabled == "1") {
                        self.bannerUrls[position](data.url || '');
                        self.enabledPositions[position](true);
                    } else {
                        self.enabledPositions[position](false);
                    }
                })
                .catch(function (error) {
                    // eslint-disable-next-line no-console
                    console.error('Creditea banner fetch error:', error && (error.message || error));
                });
        },

        getBannerUrl: function (position) {
            return this.bannerUrls[position] ? this.bannerUrls[position]() : '';
        },

        isEnabled: function (position) {
            return this.enabledPositions[position] ? this.enabledPositions[position]() : false;
        }
    });
});
