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
        yield ['/'];
        yield ['/im_a_vue_rute'];
        yield ['/administration'];
        yield ['/administration/im_a_vue_rute'];
        yield ['/identity'];
        yield ['/identity/im_a_vue_rute'];
        //yield ['/appointment/new'];
    }
}
