<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\Repository;

use ProAppointments\IdentityAccess\Tests\DataFixtures\UserFixtureBehavior;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @group doctrine
 */
class DoctrineUserRepositoryTest extends KernelTestCase
{
    use UserFixtureBehavior;

    private $userRepository;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->userRepository = $kernel->getContainer()
            ->get('test.ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\DoctrineUserRepository');
    }

    /** @test */
    public function can_register_and_retrieve_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_register_and_remove_a_user(): void
    {
        $first = list($id, $user) = $this->generateUserAggregate();
        $second = list($secondId, $secondUser) = $this->generateUserAggregate();

        $this->userRepository->register($user);
        $this->userRepository->register($secondUser);

        // remove first
        $this->userRepository->remove($user);
        $userFromDatabase = $this->userRepository->ofId($secondId);

        self::assertNull($this->userRepository->ofId($id));
        $this->assertTrue($secondUser->sameIdentityAs($userFromDatabase));
    }

    /** @test */
    public function can_save_and_retrieve_a_user(): void
    {
        list($id, $user) = $this->generateUserAggregate();

        $this->userRepository->save($user);
        $userFromDatabase = $this->userRepository->ofId($id);

        $this->assertTrue($user->sameIdentityAs($userFromDatabase));
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->userRepository = null;
    }
}
