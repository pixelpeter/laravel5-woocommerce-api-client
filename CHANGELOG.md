# Changelog

All Notable changes for the Laravel 5 WooCommerce REST API Client will be documented in this file

## 3.0.1
- Update outdated composer dependencies (phpunit, mockery)
- Add php 7.2 to travis-ci 

## 3.0.0
- Add support for Auto-Discovery (Thanks to palpalani)
- Require php 7.0+
- Upgrade to phpunit 6.2.x
- Remove composer.lock
- Narrow version for automattic/woocommerce to stick to 1.3.x
- Set default API Version to v2 in config/woocommerce.php

## 2.3.0
- Add pagination functionality.
Now these functions are available
    - totalResults()
    - firstPage()
    - lastPage()
    - currentPage()
    - totalPages()
    - previousPage()
    - nextPage()
    - hasPreviousPage()
    - hasNextPage()
    - hasNotPreviousPage()
    - hasNotNextPage()
- Get the Request & Response (Headers) from the last request
    - getRequest()
    - getResponse()

## 2.3.0
- Add pagination functionality.
Now these functions are available
    - totalResults()
    - firstPage()
    - lastPage()
    - currentPage()
    - totalPages()
    - previousPage()
    - nextPage()
    - hasPreviousPage()
    - hasNextPage()
    - hasNotPreviousPage()
    - hasNotNextPage()
- Get the Request & Response (Headers) from the last request
    - getRequest()
    - getResponse()

## 2.2.0
- Laravel 5.4 compatibility

## 2.1.0
- Add additional configuration vallues (Thanks to ebisbe)
- Update README.md

## 2.0.0
- Add support for Woocommerce 2.6+ (Thanks to leeroyrose)

## 1.0.1
- Small fixes in documentation
- Added support for "verify_ssl" config option

  Add `'WOOCOMMERCE_VERIFY_SSL', false` to your `.env` file and re-publish the configuration to have this change reflected in `config/woocommerce.php`.

## 1.0.0
- Stable first release
