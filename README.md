# SPSR PHP WRAPPER

This project aims to provide a PHP wrapper for [SPSR API](http://www.spsr.ru/en/).

## Installation

The preferred way to install is through [composer](http://getcomposer.org/download/).

Either run

```
composer require "stp/spsr-shipment *"
```

or add

```json
{
    "require": {
        "stp/spsr-shipment": "*"
    }
}
```

to the require section of your composer.json.


## Usage

### Constructing the Client

```php
use stp\spsr\SpsrApi;

$api = new SpsrApi($login, $password, $icn);
```

### Create request
Every API method has the same variable name as in official documentation.

```php

use stp\spsr\message\GetCitiesMessage,
    stp\spsr\response\City;

$msg = new GetCitiesMessage();
$msg->CityName = 'Москва';

/** @var City[] $cities */
$cities = $api->request($msg);
```
## Implemented API Methods

- [x] [Tariff Calculation](message/TariffMessage.php)
- [x] [WACreateOrder](message/CreateOrderMessage.php)
- [x] [WAXmlConverter](message/InvoiceMessage.php)
- [x] [WAGetInvoiceInfo 1.1](message/GetInvoiceInfoMessage.php)
- [x] [WABindOrderToInvoice](message/BindOrderToInvoiceMessage.php)
- [x] [WAGetActiveOrders](message/GetActiveOrdersMessage.php)
- [x] [WAGetAddress](message/GetAddressMessage.php)
- [x] [WAGetCities](message/GetCitiesMessage.php)
- [ ] WANewInvoicesByFile
- [ ] WAInvSessionInfo
- [ ] WAGetExtMon
- [ ] WAGetServices
- [ ] WAGetStreet
- [ ] WAGetEncloseType
- [ ] WAAddAddress
- [ ] WAEditAddress
- [ ] WADelAddress
- [ ] WAGetOrders
- [ ] WACancelOrder
- [ ] WACheckGetQuotaByAddress
- [ ] WAReservQuota
- [ ] WAReservQuotaDelete


## Pull requests are very welcome!
