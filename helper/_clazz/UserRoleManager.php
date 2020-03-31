<?php

namespace app\helper\_clazz;

use app\helper\_enum\UserRoleEnum;

class UserRoleManager
{

    static function removeRoleFromUser(int $id)
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
}
