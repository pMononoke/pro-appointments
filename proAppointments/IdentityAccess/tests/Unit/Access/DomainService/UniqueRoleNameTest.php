<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\Access\DomainService;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleName;
use ProAppointments\IdentityAccess\Domain\Service\UniqueRoleName\UniqueRoleNameQuery;

class UniqueRoleNameTest extends TestCase
{
    /** @var UniqueRoleNameQuery|MockObject */
    private $uniqueRoleNameQuery;
    /** @var UniqueRoleName */
    private $domainService;

    protected function setUp()
    {
        $this->uniqueRoleNameQuery = $this->getMockForAbstractClass(UniqueRoleNameQuery::class);
        $this->domainService = new UniqueRoleName($this->uniqueRoleNameQuery);
    }

    /** @test */
    public function shouldReturnTrueIfRoleNameNotExist(): void
    {
        $this->uniqueRoleNameQuery->expects($this->once())
            ->method('execute')
            ->willReturn(true);

        $isUniqueRoleName = $this->domainService->__invoke(RoleName::fromString('EXAMPLE_ROLE'));

        self::assertTrue($isUniqueRoleName);
    }

    /** @test */
    public function shouldReturnFalseIfRoleNameExist(): void
    {
        $this->uniqueRoleNameQuery->expects($this->once())
            ->method('execute')
            ->willReturn(false);

        $isUniqueRoleName = $this->domainService->__invoke(RoleName::fromString('EXAMPLE_ROLE'));

        self::assertFalse($isUniqueRoleName);
    }
}
