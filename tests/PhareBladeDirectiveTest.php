<?php

namespace Phare\PhareLaravel\Tests;

use DOMDocument;
use DOMXPath;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\View\ViewException;
use Orchestra\Testbench\TestCase;
use Phare\PhareLaravel\PhareServiceProvider;
use Phare\PharePHP\Script;
use Phare\PharePHP\Token;

class PhareBladeDirectiveTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            PhareServiceProvider::class,
        ];
    }

    protected function fullEnvironment($app): void
    {
        $app['config']->set('phare', array_merge($app['config']->get('phare'), [
            'public_key' => Str::random(),
            'secret_key' => Str::random(),
        ]));

        $app['config']->set('auth.guards.api', [
            'driver' => 'token',
            'provider' => 'users',
        ]);
    }

    /**
     * @define-env fullEnvironment
     */
    public function test_it_can_build_script(): void
    {
        $this->be((new User())->setAttribute('id', 1));

        $script = Blade::render('@phare');

        $this->assertNotNull($script);

        $document = new DomDocument();

        $document->loadHTML($script);

        $xpath = new DOMXPath($document);

        /** @var \DOMElement $scriptNode */
        $scriptNode = $xpath->query('//script')[0];

        $this->assertEquals(Script::ENDPOINT, $scriptNode->getAttribute('src'));
        $this->assertTrue($scriptNode->hasAttribute('defer'));
        $this->assertFalse($scriptNode->hasAttribute('nonce'));

        $token = $scriptNode->getAttribute('data-token');

        $jwt = JWT::decode($token, new Key(config('phare.secret_key'), Token::ALGORITHM));

        $this->assertObjectHasAttribute('aud', $jwt);
        $this->assertObjectHasAttribute('sub', $jwt);
        $this->assertObjectHasAttribute('exp', $jwt);
        $this->assertObjectHasAttribute('iat', $jwt);
        $this->assertObjectHasAttribute('nbf', $jwt);
    }

    /**
     * @define-env fullEnvironment
     */
    public function test_it_can_build_script_with_nonce(): void
    {
        $nonce = Str::random();

        $this->be((new User())->setAttribute('id', 1));

        $script = Blade::render("@phare(['nonce' => '$nonce'])");

        $this->assertNotNull($script);

        $document = new DomDocument();

        $document->loadHTML($script);

        $xpath = new DOMXPath($document);

        /** @var \DOMElement $scriptNode */
        $scriptNode = $xpath->query('//script')[0];

        $this->assertEquals(Script::ENDPOINT, $scriptNode->getAttribute('src'));
        $this->assertTrue($scriptNode->hasAttribute('defer'));
        $this->assertEquals($nonce, $scriptNode->getAttribute('nonce'));
    }

    /**
     * @define-env fullEnvironment
     */
    public function test_it_can_build_script_with_custom_guard(): void
    {
        $this->be((new User())->setAttribute('id', 1), 'api');

        $script = Blade::render("@phare(['guard' => 'api'])");

        $this->assertNotNull($script);

        $document = new DomDocument();

        $document->loadHTML($script);

        $xpath = new DOMXPath($document);

        /** @var \DOMElement $scriptNode */
        $scriptNode = $xpath->query('//script')[0];

        $this->assertEquals(Script::ENDPOINT, $scriptNode->getAttribute('src'));
        $this->assertTrue($scriptNode->hasAttribute('defer'));
        $this->assertFalse($scriptNode->hasAttribute('nonce'));
    }

    /**
     * @define-env fullEnvironment
     */
    public function test_it_dont_build_script_if_not_enabled(): void
    {
        Config::set('phare.enabled', false);

        $this->be((new User())->setAttribute('id', 1), 'api');

        $script = Blade::render("@phare()");

        $this->assertEquals('', $script);
    }

    /**
     * @define-env fullEnvironment
     */
    public function test_it_dont_build_script_if_guest(): void
    {
        $script = Blade::render("@phare()");

        $this->assertEquals('', $script);
    }

    public function test_it_cant_build_script_without_proper_config(): void
    {
        $this->expectException(ViewException::class);

        Blade::render("@phare()");
    }
}
