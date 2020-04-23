<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Enum that is used to manage user roles.
 */
class UserRoleEnum extends Enum
{

    const NONE = 'none';

    const PROJECT_MANAGER_DEVIS = 'projectManagerDevis';
    const OPERATIONAL_MANAGER_DEVIS = 'operationalManagerDevis';
    const ACCOUNTING_SUPPORT_DEVIS = 'accountingSupportDevis';
    const DEVIS_ROLE = [
        0 => UserRoleEnum::NONE,
        1 => UserRoleEnum::PROJECT_MANAGER_DEVIS,
        2 => UserRoleEnum::OPERATIONAL_MANAGER_DEVIS,
        3 => UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS
    ];
    const DEVIS_ROLE_STRING = [
        0 => 'Aucunes',
        1 => 'Chef de projet',
        2 => 'Responsable opérationnel',
        3 => 'Support comptable'
    ];

    const ADMINISTRATOR = 'administrator';
    const SUPER_ADMINISTRATOR = 'superAdministrator';
    const ADMINISTRATION_ROLE = [
        0 => UserRoleEnum::NONE,
        1 => UserRoleEnum::ADMINISTRATOR,
        2 => UserRoleEnum::SUPER_ADMINISTRATOR
    ];
    const ADMINISTRATOR_ROLE_STRING = [
        0 => 'Aucunes',
        1 => 'Administrateur',
        2 => 'Super Administrateur'
    ];
}
