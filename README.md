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

To keep communication secure between Phare and your application you must set your public and secret key in your application's `.env` file:

```dotenv
PHARE_PUBLIC_KEY=your_public_key
PHARE_SECRET_KEY=your_secret_key
```

Both keys can be found in your Phare dashboard on the [integration](https://phare.app/integration) page.

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --tag="phare-config"
```

This is the contents of the published config file:

```php
return [
    /*
    |--------------------------------------------------------------------------
    | Phare status
    |--------------------------------------------------------------------------
    |
    | By default, if included in your HTML <head> tag, Phare is enabled. This
    | option allow you to disable Phare with an environment variable,
    | without having to change your code.
    |
    */

    'enabled' => env('PHARE_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Public key
    |--------------------------------------------------------------------------
    |
    | The public key is used to identify your organization when communicating
    | with Phare. You can find your public key on the integration page of
    | your dashboard.
    |
    | https://phare.app/integration
    |
    */

    'public_key' => env('PHARE_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Secret key
    |--------------------------------------------------------------------------
    |
    | The secret key is used to encrypt user identifier, this key is set by
    | your application and Phare should never receive knowledge of it.
    | By default your Laravel APP_KEY will be used.
    |
    | https://phare.app/integration
    |
    */

    'secret_key' => env('PHARE_SECRET_KEY', env('APP_KEY')),

    /*
    |--------------------------------------------------------------------------
    | Hashing salt
    |--------------------------------------------------------------------------
    |
    | A unique user identifier (usually the user ID) is needed for Phare to
    | authenticate one of your user. To keep Phare privacy-first, all user
    | identifiers are hashed with a Salt of your choice.
    |
    | Be careful if modifying this value, user in your Phare dashboard will
    | be duplicated.
    |
    | By default, your app key is used as the salt.
    |
    */

    'salt' => env('PHARE_SALT', env('APP_KEY')),


    /*
    |--------------------------------------------------------------------------
    | Token expiration
    |--------------------------------------------------------------------------
    |
    | Expiration time, in seconds, of the generated user Token, used to
    | authenticate your users in Phare.
    |
    | The default 300 seconds should be a good value for most projects.
    |
    */

    'expiration' => 300,

    /*
    |--------------------------------------------------------------------------
    | Token leeway
    |--------------------------------------------------------------------------
    |
    | Leeway, in seconds, to prevent incorrect time validation of the token
    | in case of server clock skew.
    |
    | The default 10 seconds is more than enough, you can set the leeway
    | to 0 if you're sure your server's clock is properly configured.
    |
    */

    'leeway' => 10,
];
```

## Usage

This library will automatically detect if a user is logged in, using the default guard of your application, create a user token and render the Phare widget script.

All you need to do is call the `@phare()` blade directive in the `<head>` section of your website:

```html
<!doctype html>
<html lang="en">
<head>
  <!-- Other meta/link/scripts tags -->
  
  @phare()
</head>
<body>
  <!-- content -->
</body>
</html>
```

You can choose an authentication guard of your choice if you do not wish to load the phare script to users logging in with the default authentication guard.

```html
<head>
  @phare(['guard' => 'custom'])
</head>
```

If your application has a content security policy, you can provide a `nonce` to be added to the Phare script as follows:

```html
<head>
  @phare(['nonce' => $nonce])
</head>
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security Vulnerabilities

If you discover any security-related issues, please email [nicolas@phare.app](mailto:nicolas@phare.app) instead of using the issue tracker.

## Credits

- [Phare](https://github.com/phare)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
