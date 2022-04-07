<?php

namespace Phare\PhareLaravel;

use Phare\PhareLaravel\Exceptions\PhareConfigurationException;
use Phare\PharePHP\Script as PharePHPScript;
use Phare\PharePHP\Token;

class Script
{
    /**
     * @throws PhareConfigurationException
     */
    public static function render(array $arguments = []): ?string
    {
        if (!config('phare.enabled')) {
            return null;
        }

        foreach (['public_key', 'secret_key', 'salt', 'expiration', 'leeway'] as $key) {
            if (config("phare.$key") === null) {
                throw new PhareConfigurationException("Missing value $key in Phare configuration");
            }
        }

        $guard = $arguments['guard'] ?? config('auth.guards.default');
        $nonce = $arguments['nonce'] ?? null;

        if (!$user = auth($guard)->user()) {
            return null;
        }

        $token = (new Token(
            config('phare.public_key'),
            config('phare.secret_key'),
            config('phare.salt'),
            config('phare.expiration'),
            config('phare.leeway')
        ))->create($user->getAuthIdentifier());

        return (new PharePHPScript())->build($token, $nonce);
    }
}
