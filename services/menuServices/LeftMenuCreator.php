<?php

namespace app\services\menuServices;

use app\services\userRoleAccessServices\UserRoleManager;

/**
 * Classe qui permet de créer un menu à gauche, ou plutôt, une classe d'assistance de création d'un array utilisé pour généré un menu.
 */
class LeftMenuCreator
{

    private $priorite;
    private $name;
    private $serviceMenuActive;
    private $rolesFilter;

    private $items = [];

    function __construct(int $priorite, string $name, string $serviceMenuActive, array $rolesFilter)
    {
        $this->priorite = $priorite;
        $this->name = $name;
        $this->serviceMenuActive = $serviceMenuActive;
        $this->rolesFilter = $rolesFilter;
    }

    function addSubMenu(int $priorite, string $url, string $label, string $subServiceMenuActive, array $rolesFilter)
    {
        if (UserRoleManager::hasRoles($rolesFilter) ||  $rolesFilter == []) {
            array_push(
                $this->items,
                [
                    'Priorite' => $priorite,
                    'url' => $url,
                    'label' => $label,
                    'subServiceMenuActive' => $subServiceMenuActive
                ]
            );
        }
    }

    function getSubMenuCreated()
    {
        $subMenu = [];

        if (UserRoleManager::hasRoles($this->rolesFilter)) {
            $subMenu = [
                'priorite' => $this->priorite,
                'name' => $this->name,
                'serviceMenuActive' => $this->serviceMenuActive,
                'items' => $this->items
            ];
        }

        return $subMenu;
    }
}
