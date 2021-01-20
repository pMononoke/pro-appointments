<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /** @test */
    public function registrationWithBasicDataShouldBeSuccessfullyCompleted(): void
    {
        $simpleRegistrationData = ['email' => 'registration-email@email.com', 'password' => 'registration-password'];
        $this->client->request('POST', '/registration', $simpleRegistrationData);

        self::assertResponseRedirects();
    }

    protected function tearDown(): void
    {
        $this->client = null;
    }
}
