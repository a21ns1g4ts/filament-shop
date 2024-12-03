# This is my package filament-shop

[![Latest Version on Packagist](https://img.shields.io/packagist/v/a21ns1g4ts/filament-shop.svg?style=flat-square)](https://packagist.org/packages/a21ns1g4ts/filament-shop)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/a21ns1g4ts/filament-shop/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/a21ns1g4ts/filament-shop/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/a21ns1g4ts/filament-shop/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/a21ns1g4ts/filament-shop/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/a21ns1g4ts/filament-shop.svg?style=flat-square)](https://packagist.org/packages/a21ns1g4ts/filament-shop)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require a21ns1g4ts/filament-shop
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="filament-shop-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-shop-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-shop-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$filamentShop = new A21ns1g4ts\FilamentShop();
echo $filamentShop->echoPhrase('Hello, A21ns1g4ts!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [a21ns1g4ts](https://github.com/a21ns1g4ts)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
