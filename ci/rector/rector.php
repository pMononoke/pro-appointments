<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    // get parameters
    $parameters = $containerConfigurator->parameters();

    // paths to refactor; solid alternative to CLI arguments
    $parameters->set(Option::PATHS, [
        __DIR__.'/../../src',
        __DIR__.'/../../tests',
        __DIR__.'/../../proAppointments',
    ]);

    // is your PHP version different from the one your refactor to? [default: your PHP version]
    $parameters->set(Option::PHP_VERSION_FEATURES, '7.2');

    // Rector relies on autoload setup of your project; Composer autoload is included by default; to add more:
    $parameters->set(Option::AUTOLOAD_PATHS, [
        //__DIR__ . '/../..//bin/.phpunit/phpunit-7.5-0/vendor/autoload.php'
        __DIR__.'/../../bin/.phpunit/phpunit-7.5-0/vendor/autoload.php',
    ]);

    // Define what rule sets will be applied
    $parameters->set(Option::SETS, [
        //SetList::DEAD_CODE,
        //SetList::PHP_71,
        //SetList::PHP_72,
        SetList::SYMFONY_40,
    ]);

    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
