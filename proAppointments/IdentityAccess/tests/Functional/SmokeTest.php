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
     * dataProvider identityRouteProvider
     * @dataProvider identityUnprotectedRouteProvider
     * @dataProvider identityProtectedRouteProvider
     * @dataProvider identityUnderDevelopmentRouteProvider
     */
    public function controllersShouldReturnExpectedStatusCode(string $path, int $expectedHttpStatusCode): void
    {
        $client = static::createClient();

        $client->request('GET', $path);
        $this->assertEquals($client->getResponse()->getStatusCode(), $expectedHttpStatusCode);
    }

    public function identityUnprotectedRouteProvider(): array
    {
        return [
            'identity route login' => ['/login', Response::HTTP_OK],
            'identity route registration' => ['/registration', Response::HTTP_OK],
        ];
    }

    public function identityProtectedRouteProvider(): array
    {
        return [
            'identity route account' => ['/account', Response::HTTP_FOUND],
            'identity route change name' => ['/account/change-name', Response::HTTP_FOUND],
            'identity route change password' => ['/account/change-password', Response::HTTP_FOUND],
            'identity route change contact info' => ['/account/change-contact-info', Response::HTTP_FOUND],
        ];
    }

    public function identityUnderDevelopmentRouteProvider(): array
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
