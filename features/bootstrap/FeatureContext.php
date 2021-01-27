<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class FeatureContext implements Context
{
    use KernelDictionary;

    /** @var KernelInterface */
    private $kernel;

    /** @var ManagerRegistry */
    private $doctrine;

    /** @var ObjectManager */
    private $manager;

    /** @var SchemaTool */
    private $schemaTool;

    /** @var array<ClassMetadata> */
    private $classes;

    /**
     * FeatureContext constructor.
     */
    public function __construct(KernelInterface $kernel, ManagerRegistry $doctrine)
    {
        $this->kernel = $kernel;
        $this->doctrine = $doctrine;
        $this->manager = $doctrine->getManager();
        $this->schemaTool = new SchemaTool($this->manager);
        $this->classes = $this->manager->getMetadataFactory()->getAllMetadata();
    }

    /** @BeforeScenario */
    public function beforeScenario(): void
    {
        $this->buildSchema();
    }

    protected function buildSchema(): void
    {
        $this->schemaTool->dropSchema($this->classes);
        $this->schemaTool->createSchema($this->classes);
    }
}
