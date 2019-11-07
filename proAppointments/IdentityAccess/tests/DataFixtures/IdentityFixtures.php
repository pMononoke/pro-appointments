<?php

namespace ProAppointments\IdentityAccess\Tests\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\Persistence\ObjectManager;
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

class IdentityFixtures extends Fixture implements FixtureGroupInterface
{
    private const EMAIL = 'irrelevant-fixture@email.com';
    private const PASSWORD = 'irrelevant-fixture';
    private const FIRST_NAME = 'fixture name';
    private const LAST_NAME = 'fixture last name';
    private const MOBILE_NUMBER = '+39-392-1111111';

    public function load(ObjectManager $manager)
    {
        list($id, $user) = $this->generateUserAggregate();
        $manager->persist($user);

        list($id, $adminUser) = $this->generateAdminUserAggregate();

        $manager->persist($adminUser);
        $manager->flush();
    }

    protected function generateUserAggregate(): array
    {
        $id = UserId::generate();
        $email = UserEmail::fromString(self::EMAIL);
        $fullName = new FullName(
            $firstName = FirstName::fromString(self::FIRST_NAME),
            $lastName = LastName::fromString(self::LAST_NAME)
        );
        $contactInformation = new ContactInformation(
            $email,
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $person = new Person($id, $fullName, $contactInformation);
        $user = User::register(
            $id,
            $email,
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        return [$id, $user];
    }

    protected function generateAdminUserAggregate(): array
    {
        $id = UserId::generate();
        $email = UserEmail::fromString('admin@example.com');
        $fullName = new FullName(
            $firstName = FirstName::fromString('admin joe'),
            $lastName = LastName::fromString('doe')
        );
        $contactInformation = new ContactInformation(
            $email,
            $mobileNumber = MobileNumber::fromString('+39-392-5555555')
        );
        $person = new Person($id, $fullName, $contactInformation);
        $user = User::register(
            $id,
            $email,
            $password = UserPassword::fromString(self::PASSWORD),
            $person
        );

        return [$id, $user];
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
