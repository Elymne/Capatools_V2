<?php

namespace app\helper\_clazz;

use app\helper\_enum\UserRoleEnum;
use Yii;

class UserRoleManager
{

    static function getUserRoles(int $id)
    {
        $userRoles = Yii::$app->authManager->getAssignments($id);

        // Map this array, we just want names role. Not objects.
        $func = function ($userRole) {
            return $userRole->roleName;
        };

        return array_map($func, $userRoles);
    }

    static function removeRolesFromUser(int $id)
    {
        $auth = \Yii::$app->authManager;
        $auth->revokeAll($id);
    }

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

    static function setAdministrationRole(int $id, string $role)
    {
        switch ($role) {
            case UserRoleEnum::ADMINISTRATOR:
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

    static function getSelectedDevisRoleKey($userRoles): int
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
