<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Allow us to manage active menu.
 */
class UserRoleEnum extends Enum
{

    const PROJECT_MANAGER_DEVIS = 'projectManagerDevis';
    const OPERATIONAL_MANAGER_DEVIS = 'operationalManagerDevis';
    const ACCOUNTING_SUPPORT_DEVIS = 'accountingSupportDevis';

    const ADMINISTRATOR = 'administrator';

    public static function getRoleString(string $role): string
    {
        switch ($role) {
            case self::PROJECT_MANAGER_DEVIS:
                return 'Chef de projet';
            case self::OPERATIONAL_MANAGER_DEVIS:
                return 'Responsable opérationnel';
            case self::ACCOUNTING_SUPPORT_DEVIS:
                return 'Support comptable';
            case self::ADMINISTRATOR:
                return 'Administrateur';
            default:
                return 'Aucun';
        }
    }
}
