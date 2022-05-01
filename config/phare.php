<?php

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
    | https://pharehq.com/integration
    |
    */

    'public_key' => env('PHARE_PUBLIC_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Secret key
    |--------------------------------------------------------------------------
    |
    | The secret key is used to encrypt communication between Phare and your
    | app, and should never be publicly shared. You can find your secret
    | key on the integration page of your dashboard.
    |
    | https://pharehq.com/integration
    |
    */

    'secret_key' => env('PHARE_SECRET_KEY'),

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
