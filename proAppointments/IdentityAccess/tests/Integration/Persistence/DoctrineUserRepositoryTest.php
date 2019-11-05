<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence;

use ProAppointments\IdentityAccess\Domain\User\ContactInformation;
use ProAppointments\IdentityAccess\Domain\User\FirstName;
use ProAppointments\IdentityAccess\Domain\User\FullName;
use ProAppointments\IdentityAccess\Domain\User\LastName;
use ProAppointments\IdentityAccess\Domain\User\MobileNumber;
use ProAppointments\IdentityAccess\Domain\User\Person;
use ProAppointments\IdentityAccess\Domain\User\User;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DoctrineUserRepositoryTest extends KernelTestCase
{
    private const EMAIL = 'irrelevant@email.com';
    private const PASSWORD = 'irrelevant';
    private const FIRST_NAME = 'irrelevant';
    private const LAST_NAME = 'irrelevant';
    private const MOBILE_NUMBER = '+39-392-1111111';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $userRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->userRepository = $kernel->getContainer()
            ->get('ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineUserRepository')
    ;
    }

    /** @test */
    public function can_save_a_user(): void
    {
        $id = UserId::generate();
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $person = new Person($id, $fullName, $contactInformation);

        $user = User::register(
            $id,
            $email = UserEmail::fromString(self::EMAIL),
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        $this->userRepository->register($user);

        $this->assertInstanceOf(User::class, $this->userRepository->ofId($id));
    }

//    private function getUserRepository()
//    {
//        return $this->entityManager
//            ->getRepository(User::class)
//        ;
//
//    }

    protected function tearDown()
    {
        parent::tearDown();

        // doing this is recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
