<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Unit\User;

use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\User\ContactInformation;
use ProAppointments\IdentityAccess\Domain\User\MobileNumber;
use ProAppointments\IdentityAccess\Domain\User\UserEmail;

class ContactInformationTest extends TestCase
{
    private const EMAIL = 'irrelevant@examle.com';
    private const MOBILE_NUMBER = '+39-392-1111111';

    /** @test */
    public function can_be_created(): void
    {
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );

        self::assertEquals($email, $contactInformation->email());
        self::assertEquals($mobileNumber, $contactInformation->mobileNumber());
    }

    /** @test */
    public function can_be_compared(): void
    {
        $first = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $second = new ContactInformation(
           UserEmail::fromString('second@example.com'),
            MobileNumber::fromString('+39-392-2222222')
        );
        $copyOfFirst = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );

        self::assertFalse($first->equals($second));
        self::assertTrue($first->equals($copyOfFirst));
        self::assertFalse($second->equals($copyOfFirst));
    }

    /** @test */
    public function it_return_a_new_contactInformation_value_object_when_modify_mobile_number(): void
    {
        $contactInformation = new ContactInformation(
            $email = UserEmail::fromString(self::EMAIL),
            $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER)
        );
        $newNumber = '+39-392-2222222';

        $modifiedContactInformation = $contactInformation->changeMobileNumber(MobileNumber::fromString($newNumber));

        self::assertEquals($newNumber, $modifiedContactInformation->mobileNumber()->toString());
        self::assertFalse($modifiedContactInformation->equals($contactInformation));
    }
}
