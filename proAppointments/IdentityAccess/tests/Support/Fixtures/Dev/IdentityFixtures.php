<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Support\Fixtures\Dev;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
//use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager;
use ProAppointments\IdentityAccess\Domain\Identity\ContactInformation;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\FullName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\Person;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Tests\Support\Factory\UserFactoryGirl;

class IdentityFixtures extends Fixture implements FixtureGroupInterface
{
//    private const EMAIL = 'irrelevant-fixture@email.com';
//    private const PASSWORD = 'irrelevant-fixture';
//    private const FIRST_NAME = 'fixture name';
//    private const LAST_NAME = 'fixture last name';
//    private const MOBILE_NUMBER = '+39-392-1111111';
//
    /** @var mixed|UserFactoryGirl */
    private $userFactory;

    /**
     * IdentityFixtures constructor.
     *
     * @param $userFactory
     */
    public function __construct($userFactory = null)
    {
        $this->userFactory = $userFactory ?: new UserFactoryGirl();
    }

    public function load(ObjectManager $manager)
    {
        $manager->persist(
            $this->generateDefaultTestUser()
        );

        $manager->persist(
            $this->generateDefaultAdminUser()
        );

        $manager->flush();
    }

    protected function generateDefaultTestUser(): object
    {
        $encodedPasswod = '$argon2id$v=19$m=65536,t=4,p=1$6biXmA+2PCHZJV64T9Z3Iw$lMZtvEmPUOyBNZxvwWI4BuHzWl9A40DrwDbmTWDRvU8';
        $user = $this->userFactory->buildDefaultTestUser();
        $user->changeAccessCredentials(UserPassword::fromString($encodedPasswod));

        return $user;
    }

    protected function generateDefaultAdminUser(): object
    {
        $encodedPasswod = '$argon2id$v=19$m=65536,t=4,p=1$6biXmA+2PCHZJV64T9Z3Iw$lMZtvEmPUOyBNZxvwWI4BuHzWl9A40DrwDbmTWDRvU8';

        return $this->userFactory->build([
            'id' => UserId::generate(),
            'email' => UserEmail::fromString('admin@example.com'),
            'password' => UserPassword::fromString($encodedPasswod),
            'firstName' => FirstName::fromString('admin joe'),
            'lastName' => LastName::fromString('doe'),
            'mobileNumber' => MobileNumber::fromString('+39-392-5555555'),
        ]);
    }

    /**
     * This method must return an array of groups
     * on which the implementing class belongs to.
     *
     * @return string[]
     */
    public static function getGroups(): array
    {
        // TODO: Implement getGroups() method.
        return ['identity', 'test'];
    }
}
