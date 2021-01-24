<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group functional
 */
class SmokeTest extends WebTestCase
{
    /**
     * @test
     * @dataProvider identityRouteProvider
     */
    public function identityControllers(string $path, int $expectedHttpStatusCode): void
    {
        $client = static::createClient();

        $client->request('GET', $path);
        $this->assertEquals($client->getResponse()->getStatusCode(), $expectedHttpStatusCode);
    }

    public function identityRouteProvider(): array
    {
        return [
            // identity module
            'identity route login' => ['/login', Response::HTTP_OK],
            'identity route registration' => ['/registration', Response::HTTP_OK],
            'identity route' => ['/identity', Response::HTTP_OK],
            'identity route + vue' => ['/identity/im_a_vue_rute', Response::HTTP_OK],

            // schedule module
            'schedule route' => ['/appointment/new', Response::HTTP_INTERNAL_SERVER_ERROR],

            'index route' => ['/', Response::HTTP_OK],
            'front route' => ['/web', Response::HTTP_FOUND],
            'front route + vue' => ['/web/im_a_vue_rute', Response::HTTP_FOUND],

            'admin route' => ['/administration', Response::HTTP_FOUND],
            'admin route + vue' => ['/administration/im_a_vue_rute', Response::HTTP_FOUND],
        ];
    }
}
