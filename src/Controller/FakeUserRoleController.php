<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Normally this would be more sophisticated...
 */
class FakeUserRoleController extends AbstractController
{
    /**
     * @var string[]
     */
    private array $roles;

    public function __construct()
    {
        $this->roles = [
            'Administrátor',
            'Uživatel'
        ];
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}