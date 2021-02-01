<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use ProAppointments\IdentityAccess\Infrastructure\Persistence\Adapter\UserRepositoryAdapter;
use ProAppointments\IdentityAccess\Infrastructure\Symfony\Security\SecurityUserAdapter;
use ProAppointments\IdentityAccess\Tests\Support\Factory\UserFactoryGirl;
use ProAppointments\IdentityAccess\Tests\Support\StaticData\DefaultTestUserStaticData as TestUser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AccountControllerTest extends WebTestCase
{
    private $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /** @test */
    public function accountPageShouldBeProtected(): void
    {
        $this->client->request('GET', '/account');

        $this->assertResponseRedirects();
    }

    /** @test */
    public function accountPageShouldBeAvailableIfLoggedIn(): void
    {
        $this->doWebLogInAsTestUser();
        $crawler = $this->client->request('GET', '/account');
        $this->assertResponseIsSuccessful();

        $this->assertContains('Account', $this->client->getResponse()->getContent());
        $this->assertContains(TestUser::$email, $this->client->getResponse()->getContent());
        $this->assertContains(TestUser::$uuid, $this->client->getResponse()->getContent());
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
