<?php

namespace app\helper\_clazz;

class UserRoleManager
{
    /**
     * Attribute role to a user.
     * 
     * @param id int. Id of user.
     * @param role string. Name of role.
     * @return void.
     */
    static function setUserRole(int $id, string $role)
    {
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $auth->assign($authorRole, $id);
    }
}
