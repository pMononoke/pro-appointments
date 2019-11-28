<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Tests\Integration\Persistence\DoctrineType;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use PHPUnit\Framework\TestCase;
use ProAppointments\IdentityAccess\Domain\Identity\MobileNumber;
use ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Config\Type\DoctrineMobileNumberType;

class DoctrineMobileNumberTypeTest extends TestCase
{
    private const MOBILE_NUMBER = '+39-555-5555555';

    /** @var Type */
    private $type;

    /** @var AbstractPlatform */
    private $platform;

    public function setUp(): void
    {
        $this->platform = new MySqlPlatform();

        try {
            $this->type = Type::getType('identity_mobile_number_test');
        } catch (DBALException $e) {
        }
    }

    public static function setUpBeforeClass(): void
    {
        Type::addType('identity_mobile_number_test', DoctrineMobileNumberType::class);
    }

    /** @test */
    public function it_can_get_name(): void
    {
        $this->assertEquals('identity_mobile_number', $this->type->getName());
    }

    /** @test */
    public function it_can_convert_to_a_php_value(): void
    {
        $value = self::MOBILE_NUMBER;
        $this->assertEquals(
            MobileNumber::fromString(self::MOBILE_NUMBER),
            $this->type->convertToPHPValue($value, $this->platform)
        );
    }

    /** @test */
    public function it_can_convert_a_null_value_to_a_php_value(): void
    {
        $this->assertNull($this->type->convertToPHPValue(null, $this->platform));
    }

    /** @test */
    public function it_can_convert_to_a_database_value(): void
    {
        $mobileNumber = MobileNumber::fromString(self::MOBILE_NUMBER);
        $this->assertEquals($mobileNumber, $this->type->convertToDatabaseValue($mobileNumber, $this->platform));
    }

    /** @test */
    public function it_can_not_convert_bad_value_to_php_value(): void
    {
        $this->expectException(ConversionException::class);
        $this->type->convertToPHPValue('+39', $this->platform);
    }

    /** @test */
    public function it_requires_sql_comment_hint(): void
    {
        $this->assertTrue($this->type->requiresSQLCommentHint($this->platform));
    }

    protected function tearDown(): void
    {
        $this->platform = null;
        $this->type = null;
    }
}
