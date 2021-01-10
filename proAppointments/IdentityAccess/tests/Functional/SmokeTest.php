<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        yield ['/identity'];
        yield ['/identity/foo'];
    }
}
