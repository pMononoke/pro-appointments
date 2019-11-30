<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Config\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use ProAppointments\IdentityAccess\Domain\Access\RoleDescription;

class DoctrineRoleDescriptionType extends StringType
{
    const NAME = 'identity_role_description';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?RoleDescription
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof RoleDescription) {
            return $value;
        }
        try {
            return RoleDescription::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof RoleDescription) {
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
