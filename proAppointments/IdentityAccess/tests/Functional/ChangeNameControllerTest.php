<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use ProAppointments\IdentityAccess\Tests\Support\Factory\UserFactoryGirl;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ChangeNameControllerTest extends WebTestCase
{
    private const NEW_FIRST_NAME = 'Richard';
    private const NEW_LAST_NAME = 'Pryor';

    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /** @test */
    public function changeNamePageShouldBeProtected(): void
    {
        $this->client->request('GET', '/account/change-name');

        $this->assertResponseRedirects();
    }

    /** @test */
    public function changeNameShouldBeAvailableIfLoggedIn(): void
    {
        $this->doWebLogInAsTestUser();
        $crawler = $this->client->request('GET', '/account/change-name');
        $this->assertResponseIsSuccessful();
    }

    /** @test */
    public function CanChangePersonalName(): void
    {
        $this->doWebLogInAsTestUser();
        $crawler = $this->client->request('GET', '/account');
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('change_personal_name_form.submit.label');
        $form = $buttonCrawlerNode->form();
        $data = [
            'change_personal_name_form[first_name]' => self::NEW_FIRST_NAME,
            'change_personal_name_form[last_name]' => self::NEW_LAST_NAME,
        ];

        $this->client->submit($form, $data);

        self::assertResponseRedirects('/account');
        $this->client->followRedirect();
        self::assertContains(
            self::NEW_FIRST_NAME,
            $this->client->getResponse()->getContent()
        );
        self::assertContains(
            self::NEW_LAST_NAME,
            $this->client->getResponse()->getContent()
        );
    }

    /** @test */
    public function CanChangeOnlyFirstname(): void
    {
        $this->doWebLogInAsTestUser();
        $crawler = $this->client->request('GET', '/account');
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('change_personal_name_form.submit.label');
        $form = $buttonCrawlerNode->form();
        $data = [
            'change_personal_name_form[first_name]' => self::NEW_FIRST_NAME,
        ];

        $this->client->submit($form, $data);

        self::assertResponseRedirects('/account');
        $this->client->followRedirect();
        self::assertContains(
            self::NEW_FIRST_NAME,
            $this->client->getResponse()->getContent()
        );
    }

    /** @test */
    public function CanChangeOnlyLastname(): void
    {
        $this->doWebLogInAsTestUser();
        $crawler = $this->client->request('GET', '/account');
        $this->assertResponseIsSuccessful();
        $buttonCrawlerNode = $crawler->selectButton('change_personal_name_form.submit.label');
        $form = $buttonCrawlerNode->form();
        $data = [
            'change_personal_name_form[last_name]' => self::NEW_LAST_NAME,
        ];

        $this->client->submit($form, $data);

        self::assertResponseRedirects('/account');
        $this->client->followRedirect();
        self::assertContains(
            self::NEW_LAST_NAME,
            $this->client->getResponse()->getContent()
        );
    }

    private function doWebLogInAsTestUser()
    {
        $factory = new UserFactoryGirl();

        $user = $factory->buildDefaultTestUser();

        /** @var UserRepositoryAdapter $userRepositoy */
        $userRepositoy = self::$container->get('test.ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter');
        $userRepositoy->register($user);

        $session = self::$container->get('session');

        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';

        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken
        //$token = new UsernamePasswordToken($user, null, $firewallName, $user->getRoles());
        $token = new UsernamePasswordToken($securityUser = new SecurityUserAdapter($user), null, $firewallName, $securityUser->getRoles());
        $session->set('_security_'.$firewallContext, \serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    protected function tearDown(): void
    {
        $this->client = null;
    }
}
