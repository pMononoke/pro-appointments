<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Support\Factory;

use Faker\Factory;
use ProAppointments\IdentityAccess\Domain\Identity\FirstName;
use ProAppointments\IdentityAccess\Domain\Identity\LastName;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Domain\Identity\User;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Identity\UserFactory;
use ProAppointments\IdentityAccess\Domain\Identity\UserId;
use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Tests\Support\StaticData\DefaultTestUserStaticData as TestUser;

class UserFactoryGirl extends UserFactory
{
    protected $faker;

    /**
     * UserFactoryGirl constructor.
     *
     * @param $faker
     */
    public function __construct($faker = null)
    {
        $this->faker = \Faker\Factory::create('it_IT');
    }

    protected function getDefaults(): array
    {
        $faker = Factory::create('it_IT');

        $userId = UserId::generate();

        $email = UserEmail::fromString($faker->unique()->email);

        $password = UserPassword::fromString('xxx');

        $firstName = FirstName::fromString($faker->unique()->firstName);

        $lastName = LastName::fromString($faker->unique()->lastName);

        $mobileNumber = MobileNumber::fromString($faker->unique()->phoneNumber);

        return [
            'id' => $userId,
            'email' => $email,
            'password' => $password,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'mobileNumber' => $mobileNumber,
        ];
    }

    /**
     * Create an instance of User aggregate,
     * it is a full data (properties and events) entity.
     */
    public function build(array $arguments = []): User
    {
        if (0 === \count($arguments)) {
            $default = $this->getDefaults();

            return $this->buildWithContactInformation(
                $default['id'],
                $default['email'],
                $default['password'],
                $default['firstName'],
                $default['lastName'],
                $default['mobileNumber'],
            );
        } else {
            if ($this->isMinimumUserDataset($arguments)) {
                return $this->buildWithMinimumData(
                    $arguments['id'],
                    $arguments['email'],
                    $arguments['password'],
                );
            }

            return $this->buildWithContactInformation(
                $arguments['id'],
                $arguments['email'],
                $arguments['password'],
                $arguments['firstName'],
                $arguments['lastName'],
                $arguments['mobileNumber'],
            );
        }
    }

    private function isMinimumUserDataset(array $userData): bool
    {
        if (isset($userData['firstName']) && isset($userData['lastName']) && isset($userData['mobileNumber'])) {
            return false;
        }

        return true;
    }

    public function buildMany(int $instanceNumber): array
    {
        $users = [];

        for ($i = 0; $i < $instanceNumber; ++$i) {
            $users[] = $this->build();
        }

        return $users;
    }

    protected function getDefaultsTestUser(): array
    {
        $userId = UserId::fromString(TestUser::$uuid);

        $email = UserEmail::fromString(TestUser::$email);

        $password = UserPassword::fromString(TestUser::$password);

        $firstName = FirstName::fromString(TestUser::$firstName);

        $lastName = LastName::fromString(TestUser::$lastName);

        $mobileNumber = MobileNumber::fromString(TestUser::$mobileNumber);

        return [
            'id' => $userId,
            'email' => $email,
            'password' => $password,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'mobileNumber' => $mobileNumber,
        ];
    }

    /**
     * Create an instance of User aggregate,
     * it is a full data (properties and events) entity.
     */
    public function buildDefaultTestUser(): User
    {
        $default = $this->getDefaultsTestUser();

        return $this->buildWithContactInformation(
            $default['id'],
            $default['email'],
            $default['password'],
            $default['firstName'],
            $default['lastName'],
            $default['mobileNumber'],
        );
    }
}
