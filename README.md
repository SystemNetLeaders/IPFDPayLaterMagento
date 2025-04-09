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

## Documentation

The **minimum order value** required for this payment method to be available is defined in the file:  
`etc/config.xml`

This plugin only works with the **MXN (Mexican Peso)** currency. Therefore, you must enable support for Mexican Pesos by running:

```bash
php bin/magento config:set --scope=default --scope-code=0 currency/options/allow "MXN,USD"
php bin/magento config:set --scope=default --scope-code=0 currency/options/base MXN
php bin/magento config:set --scope=default --scope-code=0 currency/options/default MXN
```
The plugin includes automatic translations for **English (en_US)** and **Spanish (es_MX)**.  
These translations can be customized in the `i18n` folder.

To enable Spanish language and regional settings, run:
```bash
php bin/magento setup:static-content:deploy es_MX -f
php bin/magento config:set general/locale/code es_MX
php bin/magento config:set general/country/default MX
php bin/magento config:set general/region/display_all 0
php bin/magento config:set general/region/state_required MX
php bin/magento config:set general/locale/code es_MX
```

After applying any changes, if they are not reflected immediately, it is recommended to reindex and refresh the cache:

```bash
php bin/magento indexer:reindex
php bin/magento cache:clean
php bin/magento cache:flush
```