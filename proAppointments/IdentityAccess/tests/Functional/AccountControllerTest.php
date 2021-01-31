<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Functional;

use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineUserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

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
        $crawler = $this->client->request('GET', '/account');
        $this->assertResponseIsSuccessful();
        //        $expectedRedirect = '/login';
//        $crawler = $this->client->request('GET', '/registration');
//        $buttonCrawlerNode = $crawler->selectButton('register_user_form.register_user_submit.label');
//        $form = $buttonCrawlerNode->form();
//        $data = [
//            'register_user_form[email]' => 'x_registration-email@email.com',
//            'register_user_form[password][first]' => 'registration-password',
//            'register_user_form[password][second]' => 'registration-password',
//        ];
//
//        $this->client->submit($form, $data);
//
//        $this->assertResponseRedirects($expectedRedirect);
//        self::assertTrue($this->checkUserIsPersisted());
    }

//    private function checkUserIsPersisted(): bool
//    {
//        $container = $this->client->getContainer();
//
//        $specialContainer = $container->get('test.service_container');
//        $repository = $specialContainer->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineUserRepository');
//
//        /* @var DoctrineUserRepository  DoctrineUserRepository */
//        if (null === $user = $repository->findOneBy(['email' => UserEmail::fromString('x_registration-email@email.com')])) {
//            return false;
//        }
//
//        return true;
//    }

    protected function tearDown(): void
    {
        $this->client = null;
    }
}
