# Changelog

All Notable changes for the Laravel 5 WooCommerce REST API Client  will be documented in this file

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
