<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;

class MobileNumberTest extends TestCase
{
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @test */
    public function can_be_created_from_string(): void
    {
        $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER);

        self::assertEquals(self::MOBILE_NUMBER, $mobileNumber->toString());
        self::assertEquals(self::MOBILE_NUMBER, $mobileNumber->__toString());
    }

    /** @test */
    public function can_be_created_as_unknown(): void
    {
        $mobileNumber = MobileNumber::asUnknown();

        self::assertEquals('', $mobileNumber->toString());
        self::assertEquals('', $mobileNumber->__toString());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = MobileNumber::fromString(self::MOBILE_NUMBER);
        $second = MobileNumber::fromString('+39-392-2222222');
        $copyOfFirst = MobileNumber::fromString(self::MOBILE_NUMBER);
        $unknown = MobileNumber::asUnknown();
        $otherUnknown = MobileNumber::asUnknown();

        self::assertFalse($first->equals($second));
        self::assertTrue($first->equals($copyOfFirst));
        self::assertFalse($second->equals($copyOfFirst));
        self::assertTrue($unknown->equals($otherUnknown));
        self::assertFalse($unknown->equals($first));
    }

    /** @test */
    public function it_return_a_new_mobileNumber_value_object_if_modified(): void
    {
        $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER);
        $newNumber = '+39-392-2222222';

        $modifiedMobileNumber = $mobileNumber->withMobileNumber($newNumber);

        self::assertEquals($newNumber, $modifiedMobileNumber->toString());
        self::assertFalse($modifiedMobileNumber->equals($mobileNumber));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function a_short_mobile_number_throw_excetion(): void
    {
        $mobileNumber = MobileNumber::fromString('+39');
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function a_long_mobile_number_throw_excetion(): void
    {
        $mobileNumber = MobileNumber::fromString('+39-11111-11111-11111-11111');
    }
}
