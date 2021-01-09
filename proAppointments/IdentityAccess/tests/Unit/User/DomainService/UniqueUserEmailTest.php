<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User\DomainService;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\UserEmail;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmail;
use ProAppointments\IdentityAccess\Domain\Service\UniqueUserEmail\UniqueUserEmailQuery;

class UniqueUserEmailTest extends TestCase
{
    /** @var UniqueUserEmail */
    private $domainService;

    /** @var UniqueUserEmailQuery|MockObject */
    private $uniqueUserEmailQuery;

    protected function setUp(): void
    {
        $this->uniqueUserEmailQuery = $this->getMockForAbstractClass(UniqueUserEmailQuery::class);
        $this->domainService = new UniqueUserEmail($this->uniqueUserEmailQuery);
    }

    /** @test */
    public function shouldReturnTrueIfUserExistNotExist(): void
    {
        $this->uniqueUserEmailQuery->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $result = $this->domainService->__invoke(UserEmail::fromString('example@example.com'));

        self::assertTrue($result);
    }

    /** @test */
    public function shouldReturnFalseIfUserExist(): void
    {
        $this->uniqueUserEmailQuery->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $result = $this->domainService->__invoke(UserEmail::fromString('example@example.com'));

        self::assertTrue($result);
    }
}
