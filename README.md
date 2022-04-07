# Laravel integration for the Phare user testing platform

[![Latest Version on Packagist](https://img.shields.io/packagist/v/phare/phare-laravel.svg?style=flat-square)](https://packagist.org/packages/phare/phare-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/phare/phare-laravel/run-tests?label=tests)](https://github.com/phare/phare-laravel/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/phare/phare-laravel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/phare/phare-laravel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/phare/phare-laravel.svg?style=flat-square)](https://packagist.org/packages/phare/phare-laravel)

Integrate the [Phare privacy first, in-app user testing platform](https://phare.app/) into your Laravel applications.

## Installation

You can install the package via composer:

```bash
composer require phare/phare-laravel
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="phare-config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$phare = new Phare\Phare();
echo $phare->echoPhrase('Hello, Phare!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover any security-related issues, please email [nicolas@phare.app](mailto:nicolas@phare.app) instead of using the issue tracker.

## Credits

- [Phare](https://github.com/phare)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
