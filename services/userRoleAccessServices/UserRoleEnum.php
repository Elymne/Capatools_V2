<?php

namespace app\services\userRoleAccessServices;

/**
 * Enum that is used to manage user roles.
 */
class UserRoleEnum
{
    const NONE = 'none';
    const SALARY = 'salary';
    const PROJECT_MANAGER = 'projectManager';
    const CELLULE_MANAGER = 'celluleManager';
    const HUMAN_RESSOURCES = 'humanRessources';
    const ACCOUNTING_SUPPORT = 'accountingSupport';
    const ADMIN = 'admin';
    const SUPER_ADMIN = 'superAdmin';
}
