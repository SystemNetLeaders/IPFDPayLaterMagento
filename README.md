# Creditea Payment Method for Magento 2
When you integrate Creditea as a payment method, offer your customers the possibility to obtain a line of credit to shop in your store and split their payments in up to 60 fortnights.

## Compatibility
✓ Magento 2.3.x, ✓ Magento 2.4.x
<br/>

######  Execute the following command on the magento root path

### Instalation

```
composer require paylateripfd/magento

php bin/magento module:enable Creditea_Magento2
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

### Update

```
composer update paylateripfd/magento

php bin/magento module:enable Creditea_Magento2
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```

### Remove

```
php bin/magento module:disbale Creditea_Magento2
composer remove paylateripfd/magento
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento cache:flush
```