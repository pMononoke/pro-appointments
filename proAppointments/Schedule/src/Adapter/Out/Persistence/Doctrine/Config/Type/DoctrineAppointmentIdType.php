<?php

declare(strict_types=1);

namespace ProAppointments\Schedule\Adapter\Out\Persistence\Doctrine\Config\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use ProAppointments\Schedule\Domain\Appointment\AppointmentId;
use Ramsey\Uuid\Doctrine\UuidType;

class DoctrineAppointmentIdType extends UuidType
{
    const NAME = 'schedule_appointment_id';

    /**
     * @param \Ramsey\Uuid\UuidInterface|string|null $value
     *
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?AppointmentId
    {
        if (empty($value)) {
            return null;
        }
        if ($value instanceof AppointmentId) {
            return $value;
        }
        try {
            return AppointmentId::fromString($value);
        } catch (\Exception $ex) {
            throw ConversionException::conversionFailed($value, self::NAME);
        }
    }

    /**
     * @param \Ramsey\Uuid\UuidInterface|string|null $value
     *
     * @throws ConversionException
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        if ($value instanceof AppointmentId) {
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
