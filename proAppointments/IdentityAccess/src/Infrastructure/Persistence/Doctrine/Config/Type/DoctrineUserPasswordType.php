<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Config\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use ProAppointments\IdentityAccess\Domain\User\UserPassword;

class DoctrineUserPasswordType extends StringType
{
    const NAME = 'identity_password';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserPassword
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof UserPassword) {
            return $value;
        }
        try {
            return UserPassword::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof UserPassword) {
            return $value->toString();
        }
        throw ConversionException::conversionFailed($value, self::NAME);
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getName()
    {
        return self::NAME;
    }
}
