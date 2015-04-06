# Usage

## Constructing the Client

```php
use stp\spsr\SpsrApi;

$api = new SpsrApi($login, $password, $icn);
```

## Tariff Calculation

Get delivery rates.

- Request: [message\TariffMessage](message/TariffMessage.php)
- Response: [response\Tariff](response/Tariff.php)

```php
use stp\spsr\message\TariffMessage,
    stp\spsr\response\Tariff;

$msg = new TariffMessage();
$msg->ToCity = $city->City . '|' . $city->City_Owner_ID; //see response\City
$msg->FromCity = $city->City . '|' . $city->City_Owner_ID;
$msg->Weight = 14;
$msg->ByHand = 1;

/** @var Tariff[] $tariffs */
$tariffs = $api->request($msg);
```

See [message\TariffMessage](message/TariffMessage.php) for more information.
