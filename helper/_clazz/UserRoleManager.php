<?php

namespace app\helper\_clazz;

use app\helper\_enum\UserRoleEnum;
use Yii;

/**
 * Classe permettant de gérer la gestion des droits de Yii2.
 * Cette classe fonctionne de paire avec la classe UserRoleEnum.
 */
class UserRoleManager
{

    /**
     * Récupère tous les droits d'un utilisateur depuis sont id.
     * @param int $id : identifiant utilisateur.
     * 
     * @return array La liste sous forme de string de tous les rôles de l'utilisateur.
     */
    static function getUserRoles(int $id): array
    {
        $userRoles = Yii::$app->authManager->getAssignments($id);

        // Map this array, we just want names role. Not objects.
        $func = function ($userRole) {
            return $userRole->roleName;
        };

        return array_map($func, $userRoles);
    }

    /**
     * Retire tous les droits d'un utilisateur.
     * @param int $id : identifiant utilisateur.
     */
    static function removeRolesFromUser(int $id)
    {
        $auth = \Yii::$app->authManager;
        $auth->revokeAll($id);
    }

    /**
     * Attribue un droit à un utilisateur sur le service des devis.
     * @param int $id : identifiant utilisateur.
     * @param string $role : UserRoleEnum.
     */
    static function setDevisRole(int $id, string $role)
    {
        switch ($role) {
            case UserRoleEnum::PROJECT_MANAGER_DEVIS:
                self::setRole($id, $role);
                break;
            case UserRoleEnum::OPERATIONAL_MANAGER_DEVIS:
                self::setRole($id, $role);
                break;
            case UserRoleEnum::ACCOUNTING_SUPPORT_DEVIS:
                self::setRole($id, $role);
                break;
        }
    }

    /**
     * Attribue un droit à un utilisateur sur le service d'administration.
     * @param int $id : identifiant utilisateur.
     * @param string $role : UserRoleEnum.
     */
    static function setAdministrationRole(int $id, string $role)
    {
        switch ($role) {
            case UserRoleEnum::ADMINISTRATOR:
                self::setRole($id, $role);
                break;
            case UserRoleEnum::SUPER_ADMINISTRATOR:
                self::setRole($id, $role);
                break;
        }
    }

    private static function setRole(int $id, string $role)
    {
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $auth->assign($authorRole, $id);
    }

    /**
     * Récupère l'index l'index du droit d'un utilisateur sur le service devis.
     * L'utilité de cette fonction réside dans le fait de pouvoir lister les droits dans une liste selectionnable.
     * @param array $userRole : Liste de tous les droits d'un utilisateur.
     */
    static function getSelectedDevisRoleKey(array $userRoles): int
    {
        $result = 0;

        foreach (UserRoleEnum::DEVIS_ROLE as $key => $role) {
            $value = array_search($role, $userRoles);
            if ($value != null) {
                $result =  $key;
            }
        }

        return $result;
    }

    /**
     * Récupère l'index l'index du droit d'un utilisateur sur le service d'administration.
     * L'utilité de cette fonction réside dans le fait de pouvoir lister les droits dans une liste selectionnable.
     * @param array $userRole : Liste de tous les droits d'un utilisateur.
     */
    static function getSelectedAdminRoleKey($userRoles): int
    {

        $result = 0;

        foreach (UserRoleEnum::ADMINISTRATION_ROLE as $key => $role) {
            $value = array_search($role, $userRoles);
            if ($value != null) {
                $result = $key;
            }
        }

        return $result;
    }
}
