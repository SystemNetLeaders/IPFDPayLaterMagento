define([
    'uiComponent',
    'mage/url',
    'Magento_Checkout/js/model/quote'
], function (Component, urlBuilder, quote) {
    'use strict';
    
    return Component.extend({
        defaults: {
            template: 'Creditea_Magento2/checkout/summary',
            bannerUrl: ''
        },
        
        initialize: function () {
            this._super();
            this.initBannerUrl();
            return this;
        },
        
        initBannerUrl: function () {
            var self = this;
            var timestamp = new Date().getTime();
            this.bannerUrl = urlBuilder.build('creditea/banner/geturl') + '?_=' + timestamp;
            fetch(this.bannerUrl, {
                method: 'GET',
                cache: 'no-store'
            })
            .then(function(response) {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(function(data) {
                console.log('Pobrane dane:', data);
                var crediteaJson = JSON.parse(data);
                self.bannerUrl = crediteaJson.url;
                document.querySelector('.creditea-banner-image').src = crediteaJson.url;
            })
            .catch(function(error) {
                console.error('Fetch error:', error);
            });
            
        },
        
        getBannerUrl: function () {
            return this.bannerUrl;
        }
    });
});