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
        $client = static::createClient();
        $client->request('GET', $path);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function identityRouteProvider(): \Generator
    {
        $webserver = 'http://127.0.0.1:8080';
        yield [$webserver.'/identity'];
        yield [$webserver.'/identity/foo'];
    }
}
