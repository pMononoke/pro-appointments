<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\DomainService;

use ProAppointments\IdentityAccess\Domain\Identity\UserPassword;
use ProAppointments\IdentityAccess\Infrastructure\DomainService\PasswordEncoderSymfony;
use ProAppointments\IdentityAccess\Tests\DataFixtures\IrrelevantUserFixtureBehavior;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordEncoderSymfonyTest extends KernelTestCase
{
    use IrrelevantUserFixtureBehavior;

    private $domainPasswordEncoder;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $symfonyEncoder = $kernel->getContainer()
            ->get('security.password_encoder');

        $this->domainPasswordEncoder = new PasswordEncoderSymfony($symfonyEncoder);
    }

    /** @test */
    public function shouldEncodeAPlainPassword(): void
    {
        $user = $this->generateUserAggregate();
        $plainPassword = 'fooo';

        $encodedPasswordAsVO = $this->domainPasswordEncoder->encode($user, $plainPassword);

        self::assertFalse($encodedPasswordAsVO->equals(UserPassword::fromString($plainPassword)));
    }

    /** @test */
    public function passwordEncodingShouldFailForUnknownUserClass(): void
    {
        self::expectException(\InvalidArgumentException::class);

        $user = new stdClass();
        $plainPassword = 'fooo';

        $encodedPasswordAsVO = $this->domainPasswordEncoder->encode($user, $plainPassword);

        self::assertFalse($encodedPasswordAsVO->equals(UserPassword::fromString($plainPassword)));
    }

    protected function tearDown()
    {
        $this->domainPasswordEncoder = null;
    }
}
