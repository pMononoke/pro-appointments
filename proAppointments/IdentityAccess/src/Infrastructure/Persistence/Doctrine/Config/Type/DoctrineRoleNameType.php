<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Config\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use ProAppointments\IdentityAccess\Domain\Access\RoleName;

class DoctrineRoleNameType extends StringType
{
    const NAME = 'identity_role_name';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?RoleName
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof RoleName) {
            return $value;
        }
        try {
            return RoleName::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof RoleName) {
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
