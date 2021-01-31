<?php

declare(strict_types=1);

namespace App\Tests\Functional\Login;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    private const USER = 'demo_user';
    private const PASSWORD_USER = 'demo';
    private const ADMIN = 'demo_admin';
    private const PASSWORD_ADMIN = 'demo';

    /** @var KernelBrowser */
    private $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    /** @test */
    public function loginPageShouldBeAvailable(): void
    {
        $this->client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }

    /**
     * @test
     * @dataProvider validCredentialsProvider
     */
    public function aVisitorWithValidCredentialsShouldBeLoggedIn(string $inputUsername, string $inputPassword, string $expectedRedirect): void
    {
        $crawler = $this->client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Sign in');
        $form = $buttonCrawlerNode->form();
        $data = ['username' => $inputUsername, 'password' => $inputPassword];

        $this->client->submit($form, $data);

        $this->assertResponseRedirects($expectedRedirect);
    }

    /**
     * @return array<array<string>>
     */
    public function validCredentialsProvider(): array
    {
        return [
            'demo user' => [self::USER, self::PASSWORD_USER, '/web'],
            'admin user' => [self::ADMIN, self::PASSWORD_ADMIN, '/administration'],
        ];
    }
}
