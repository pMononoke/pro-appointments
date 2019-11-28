<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Config\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use ProAppointments\IdentityAccess\Domain\Access\RoleId;
use Ramsey\Uuid\Doctrine\UuidType;

class DoctrineRoleIdType extends UuidType
{
    const NAME = 'identity_role_id';

    public function convertToPHPValue($value, AbstractPlatform $platform): ?RoleId
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof RoleId) {
            return $value;
        }
        try {
            return RoleId::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof RoleId) {
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
