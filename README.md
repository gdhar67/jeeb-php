# Jeeb PHP library for API v2

PHP library for Jeeb API.

You can sign up for a Jeeb account at <https://jeeb.com> for production and <https://sandbox.jeeb.com> for testing (sandbox).

Please note, that for Sandbox you must generate separate API credentials on <https://sandbox.jeeb.com>. API credentials generated on <https://jeeb.com> will not work for Sandbox mode.

## Composer

You can install library via [Composer](http://getcomposer.org/). Run the following command in your terminal:

```bash
composer require jeeb/jeeb-php
```

## Manual Installation

Donwload [latest release](https://github.com/jeeb/jeeb-php/releases) and include `init.php` file.

```php
require_once('/path/to/jeeb-php/init.php');
```

## Getting Started

Usage of Jeeb PHP library.

### Setting up Jeeb library

#### Setting default authentication

```php
use Jeeb\Jeeb;

\Jeeb\Jeeb::config(array(
    'environment'               => 'sandbox', // sandbox OR live
    'auth_token'                => 'YOUR_AUTH_TOKEN',
    'curlopt_ssl_verifypeer'    => TRUE // default is false
));

// $order = \Jeeb\Merchant\Order::find(7294);
```

#### Setting authentication individually

```php
use Jeeb\Jeeb;

# \Jeeb\Merchant\Order::find($orderId, $options = array(), $authentication = array())

$order = \Jeeb\Merchant\Order::find(1087999, array(), array(
    'environment' => 'sandbox', // sandbox OR live
    'auth_token' => 'YOUR_AUTH_TOKEN'));
```

### Creating Merchant Order

https://developer.jeeb.com/docs/create-order

```php
use Jeeb\Jeeb;

$post_params = array(
                   'order_id'          => 'YOUR-CUSTOM-ORDER-ID-115',
                   'price_amount'      => 1050.99,
                   'price_currency'    => 'USD',
                   'receive_currency'  => 'EUR',
                   'callback_url'      => 'https://example.com/payments/callback?token=6tCENGUYI62ojkuzDPX7Jg',
                   'cancel_url'        => 'https://example.com/cart',
                   'success_url'       => 'https://example.com/account/orders',
                   'title'             => 'Order #112',
                   'description'       => 'Apple Iphone 6'
               );

$order = \Jeeb\Merchant\Order::create($post_params);

if ($order) {
    echo $order->status;
    
    print_r($order);
} else {
    # Order Is Not Valid
}
```

### Getting Merchant Order

https://developer.jeeb.com/docs/get-order

```php
use Jeeb\Jeeb;

try {
    $order = \Jeeb\Merchant\Order::find(7294);

    if ($order) {
      var_dump($order);
    }
    else {
      echo 'Order not found';
    }
} catch (Exception $e) {
  echo $e->getMessage(); // BadCredentials Not found App by Access-Key
}
```

### Test API Credentials

```php
$testConnection = \Jeeb\Jeeb::testConnection(array(
  'environment'   => 'sandbox',
  'auth_token'    => 'YOUR_AUTH_TOKEN'
));

if ($testConnection !== true) {
  echo $testConnection; // Jeeb\BadCredentials: BadCredentials Not found App by Access-Key
}
```
