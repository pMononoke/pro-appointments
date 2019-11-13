<?php

declare(strict_types=1);

namespace CompostDDD\Time;

use DateTimeImmutable;

interface Clock
{
    public function dateTime(): DateTimeImmutable;

    //public function pointInTime(): PointInTime;
}
