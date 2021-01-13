<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;

/**
 * @group functional
 */
class SmokeTest extends WebTestCase
{
    /** @var Client */
    private static $client;

    protected function setUp(): void
    {
        //self::$client = static::createClient();
        //self::$client->followRedirect(true);
        //self::$container = self::$client->getContainer();
    }

    /**
     * @test
     * @dataProvider identityRouteProvider
     */
    public function identityControllers(string $path): void
    {
        $webserver = 'http://199.0.0.1';
        $client = static::createClient([], ['HTTP_HOST' => $webserver]);
        $client->request('GET', $path);
        \var_dump($client->getResponse()->getContent());
        $this->assertTrue($client->getResponse()->isSuccessful());


    }

    public function identityRouteProvider(): \Generator
    {
        yield ['/'];
        //yield ['/identity'];
        //yield ['/identity/foo'];
    }
}
