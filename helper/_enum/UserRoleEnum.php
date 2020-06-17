<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Enum that is used to manage user roles.
 */
class UserRoleEnum extends Enum
{

    const NONE = 'none';
    const SALARY = 'salary';
    const PROJECT_MANAGER = 'projectManager';
    const CELLULE_MANAGER = 'celluleManager';
    const HUMAN_RESSOURCES = 'humanRessources';
    const SUPPORT = 'support';
    const ADMIN = 'admin';
    const SUPER_ADMIN = 'superAdmin';
}
