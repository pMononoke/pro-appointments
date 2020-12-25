<?php

declare(strict_types=1);

namespace CompostDDD\Tests\ApplicationService;

use CompostDDD\ApplicationService\ApplicationService;
use PHPUnit\Framework\TestCase;

class TransationalApplicationServiceFactoryTest extends TestCase
{
    /** @test */
    public function can_create_transactional_application_service(): void
    {
        $transactionalService = DummyTransationalApplicationServiceFactory::createTransationalApplicationService(
            new DummyApplicationService(),
            new DummyTransationalSession()
        );

        self::assertInstanceOf(ApplicationService::class, $transactionalService);

        self::assertTrue(
            \method_exists($transactionalService, 'execute'),
            'Class does not have method myFunction'
        );
    }
}
