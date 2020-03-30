<?php

namespace app\helper\_enum;

use MyCLabs\Enum\Enum;

/**
 * Allow us to manage active menu.
 */
class UserRoleEnum extends Enum
{

    const NONE = 'none';

    const PROJECT_MANAGER_DEVIS = 'projectManagerDevis';
    const OPERATIONAL_MANAGER_DEVIS = 'operationalManagerDevis';
    const ACCOUNTING_SUPPORT_DEVIS = 'accountingSupportDevis';
    const DEVIS_ROLE = [
        UserRoleEnum::PROJECT_MANAGER_DEVIS,
        UserRoleEnum::OPERATIONAL_MANAGER_DEVIS,
        UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS
    ];
    const DEVIS_ROLE_STRING = [
        'Chef de projet',
        'Responsable opérationnel',
        'Support comptable',
        'Aucun'
    ];

    const ADMINISTRATOR = 'administrator';
    const ADMINISTRATION_ROLE = [
        UserRoleEnum::ADMINISTRATOR
    ];
    const ADMINISTRATOR_ROLE_STRING = [
        'Administrateur',
        'Aucun'
    ];

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
            case self::NONE:
                return 'Aucun';
            default:
                return 'Aucun';
        }
    }

    public static function getRoleEnum(string $roleString): string
    {
        switch ($roleString) {
            case 'Chef de projet':
                return self::PROJECT_MANAGER_DEVIS;
            case 'Responsable opérationnel':
                return self::OPERATIONAL_MANAGER_DEVIS;
            case 'Support comptable':
                return self::ACCOUNTING_SUPPORT_DEVIS;
            case 'Administrateur':
                return self::ADMINISTRATOR;
            case 'Aucun':
                return self::NONE;
            default:
                return self::NONE;
        }
    }
}
