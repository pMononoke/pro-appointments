<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group functional
 */
class SmokeTest extends WebTestCase
{
    /**
     * @test
     * @dataProvider identityRouteProvider
     */
    public function identityControllers(string $path): void
    {
        $webserver = 'http://127.0.0.1';
        $client = static::createClient([], ['HTTP_HOST' => $webserver]);
        $client->request('GET', $path);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function identityRouteProvider(): \Generator
    {
        yield ['/'];
        //yield ['/identity'];
        //yield ['/identity/foo'];
    }
}
