# Laravel 5 WooCommerce API Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pixelpeter/laravel5-woocommerce-api-client.svg?style=flat-square)](https://packagist.org/packages/pixelpeter/laravel5-woocommerce-api-client)
[![Total Downloads](https://img.shields.io/packagist/dt/pixelpeter/laravel5-woocommerce-api-client.svg?style=flat-square)](https://packagist.org/packages/pixelpeter/laravel5-woocommerce-api-client)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Coverage Status](https://coveralls.io/repos/github/pixelpeter/laravel5-woocommerce-api-client/badge.svg?branch=master)](https://coveralls.io/github/pixelpeter/laravel5-woocommerce-api-client?branch=master)
[![Tests](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/run-tests.yml/badge.svg?branch=master)](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/run-tests.yml)
[![Fix PHP code style issues](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/fix-php-code-style-issues.yml/badge.svg)](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/fix-php-code-style-issues.yml)
[![PHPStan](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/phpstan.yml/badge.svg)](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/phpstan.yml)
[![dependabot-auto-merge](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/dependabot-auto-merge.yml/badge.svg)](https://github.com/pixelpeter/laravel5-woocommerce-api-client/actions/workflows/dependabot-auto-merge.yml)

A simple Laravel 5 wrapper for the [official WooCommerce REST API PHP Library](https://github.com/woothemes/wc-api-php) from Automattic.

## Version overview

| Laravel | wc-api-php used | Wordpress |  Woocommerce  |          WC API version           | use branch |
| ------  | --------------- | --------- | ------------- | --------------------------------- |------------|  
| 5.7+    | 2.x             | 4.4+      | 3.5+          | v1, v2, v3                        | master     |
| 5.5+    | 1.3.x           | 4.4+      | 3.0 - 3.4.x   | v1, v2, v3                        | ^3.0       |
| 5.4+    | 1.3.x           | 4.4+      | 2.6 - 2.6.14  | v1, v2                            | ^2.0       |
| 5.3     | 1.3.x           | 4.1+      | 2.1 - 2.5.5   | legacy v1, legacy v2, legacy v3   | ^1.0       |

## Installation

### Step 1: Install Through Composer

For API Version v2, WooCommerce 3.0+, Wordpress 4.4+, php 7.0+, Laravel 5.5+ use the v3.x branch
``` bash
composer require pixelpeter/laravel5-woocommerce-api-client ^3.0
```

For API Version v1, WooCommerce 2.6+, Wordpress 4.4+, Laravel 5.4+ use the v2.x branch
``` bash
composer require pixelpeter/laravel5-woocommerce-api-client ^2.0
```

For older versions of Woocommerce starting from 2.1+ use the v1.x branch
``` bash
composer require pixelpeter/laravel5-woocommerce-api-client ^1.0
```

### Step 2: Add the Service Provider (not needed with v3.x)
Add the service provider in `app/config/app.php`
```php
'provider' => [
    ...
    Pixelpeter\Woocommerce\WoocommerceServiceProvider::class,
    ...
];
```

### Step 3: Add the Facade (not needed with v3.x)
Add the alias in `app/config/app.php`
```php
'aliases' => [
    ...
    'Woocommerce' => Pixelpeter\Woocommerce\Facades\Woocommerce::class,
    ...
];
```

### Step 4: Publish configuration
``` bash
php artisan vendor:publish --provider="Pixelpeter\Woocommerce\WoocommerceServiceProvider"
```

### Step 5: Customize configuration
You can directly edit the configuration in `config/woocommerce.php` or copy these values to your `.env` file.
```php
WOOCOMMERCE_STORE_URL=http://example.org
WOOCOMMERCE_CONSUMER_KEY=ck_your-consumer-key
WOOCOMMERCE_CONSUMER_SECRET=cs_your-consumer-secret
WOOCOMMERCE_VERIFY_SSL=false
WOOCOMMERCE_VERSION=v1
WOOCOMMERCE_WP_API=true
WOOCOMMERCE_WP_QUERY_STRING_AUTH=false
WOOCOMMERCE_WP_TIMEOUT=15
```

## Examples

### Get the index of all available endpoints
```php
use Woocommerce;

return Woocommerce::get('');
```

### View all orders
```php
use Woocommerce;

return Woocommerce::get('orders');
```

### View all completed orders created after a specific date
#### For legacy API versions 
(WC 2.4.x or later, WP 4.1 or later) use this syntax

```php
use Woocommerce;

$data = [
    'status' => 'completed',
    'filter' => [
        'created_at_min' => '2016-01-14'
    ]
];

$result = Woocommerce::get('orders', $data);

foreach($result['orders'] as $order)
{
    // do something with $order
}

// you can also use array access
$orders = Woocommerce::get('orders', $data)['orders'];

foreach($orders as $order)
{
    // do something with $order
}
```

#### For current API versions 
(WC 2.6.x or later, WP 4.4 or later) use this syntax.
`after` needs to be a ISO-8601 compliant date!≠

```php
use Woocommerce;

$data = [
    'status' => 'completed',
    'after' => '2016-01-14T00:00:00'
    ]
];

$result = Woocommerce::get('orders', $data);

foreach($result['orders'] as $order)
{
    // do something with $order
}

// you can also use array access
$orders = Woocommerce::get('orders', $data)['orders'];

foreach($orders as $order)
{
    // do something with $order
}
```

### Update a product
```php
use Woocommerce;

$data = [
    'product' => [
        'title' => 'Updated title'
    ]
];

return Woocommerce::put('products/1', $data);
```

### Pagination
So you don't have to mess around with the request and response header and the calculations this wrapper will do all the heavy lifting for you.
(WC 2.6.x or later, WP 4.4 or later) 

```php
use Woocommerce;

// assuming we have 474 orders in pur result
// we will request page 5 with 25 results per page
$params = [
    'per_page' => 25,
    'page' => 5
];

Woocommerce::get('orders', $params);

Woocommerce::totalResults(); // 474
Woocommerce::firstPage(); // 1
Woocommerce::lastPage(); // 19
Woocommerce::currentPage(); // 5 
Woocommerce::totalPages(); // 19
Woocommerce::previousPage(); // 4
Woocommerce::nextPage(); // 6
Woocommerce::hasPreviousPage(); // true 
Woocommerce::hasNextPage(); // true
Woocommerce::hasNotPreviousPage(); // false 
Woocommerce::hasNotNextPage(); // false
```

In some cases the web server returns headers only in lower case. This may cause errors when
using the pagination functions. If that is your case, call the following method before calling 
any pagination methods.

```php
use Woocommerce;

Woocommerce::useLowerCaseHeaders();
```

### HTTP Request & Response (Headers)

```php
use Woocommerce;

// first send a request
Woocommerce::get('orders');

// get the request
Woocommerce::getRequest();

// get the response headers
Woocommerce::getResponse();

// get the total number of results
Woocommerce::getResponse()->getHeaders()['X-WP-Total']
```

### More Examples
Refer to [WooCommerce REST API Documentation](https://woocommerce.github.io/woocommerce-rest-api-docs) for more examples and documention.

## Testing
Run the tests with:
```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
