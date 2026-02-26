# Shopware ProductFlow Integration
Implements the missing integration for [ProductFlow's](www.productflow.com/) offers and orders as a custom datamodel connector for [Shopware 6](https://www.shopware.com/en/).

## Requirements
1. PHP version 8.4 or higher.
2. Shopware 6.7.

## Features
The integration supports the following features:
1. Offer updates.
2. Order synchronisation.

## Installation
Installation through composer is preferred.

```
composer require positivedigits/shopware-productflow-integration
```

Next, install the plugin.

```
./bin/console plugin:install --activate ProductFlowIntegration
```

## Configuration
After installation, configure the integration in [ProductFlow](https://cloud.productflow.com/marketplace)

| Name           | Description                                                                                                                                                    | Example                                |
|----------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------|
| Token          | Authorization token passed from ProductFlow to Shopware in the `Authorization` header. *Note*: this value should be configured in the plugin settings as well. | `d82949c3-29d1-4710-8e73-5d62ce8a60cd` |
| Offer endpoint | The URL on which ProductFlow fetches offers from Shopware. Replace `example.com` with your shops domain!                                                       | `https://example.com/offer`            |
| Order endpoint | The URL on which ProductFlow fetches orders from Shopware. Replace `example.com` with your shops domain!                                                       | `https://example.com/orders`           |

**Ensure that 'Schakel ordersynchronisatie in' and 'Schakel synchronisatie van offers in' are enabled in ProductFlow!**

Finally, make sure the authorization token set in ProductFlow is also provided in the Shopware plugin configuration.

## Issues
If any issues are encountered, please feel free to [open an issue](https://github.com/positivedigits/shopware-productflow-integration/issues/new?template=bug_report.yml).