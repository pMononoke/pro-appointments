<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\Doctrine\Config\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use ProAppointments\IdentityAccess\Domain\User\UserId;
use Ramsey\Uuid\Doctrine\UuidType;

class DoctrineUserIdType extends UuidType
{
    const NAME = 'identity_user_id';

    /**
     * @param \Ramsey\Uuid\UuidInterface|string|null $value
     * @param AbstractPlatform                       $platform
     *
     * @return UserId|null
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?UserId
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof UserId) {
            return $value;
        }
        try {
            return UserId::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface|string|null $value
     * @param AbstractPlatform                       $platform
     *
     * @return string|null
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof UserId) {
            return $value->toString();
        }
        throw ConversionException::conversionFailed($value, self::NAME);
    }

    public function getName()
    {
        return self::NAME;
    }
}
