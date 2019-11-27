<?php

declare(strict_types=1);

namespace ProAppointments\IdentityAccess\Infrastructure\Persistence\InMemory;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class InMemoryRoleCollection
{
    /** @var InfrastructureRoleRepository */
    private $roleRepository;

    /** @var Collection */
    private $roleCollection;

    /**
     * InMemoryRoleCollection constructor.
     */
    public function __construct(InfrastructureRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        $this->roleCollection = new ArrayCollection($roleRepository->allRoles());
    }
}
