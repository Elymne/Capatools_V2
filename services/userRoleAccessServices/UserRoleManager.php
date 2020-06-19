<?php

namespace app\services\userRoleAccessServices;

use app\models\users\CapaUserCreateForm;
use Yii;

/**
 * Classe permettant de gérer la gestion des droits de Yii2.
 * Cette classe fonctionne de paire avec la classe UserRoleEnum.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
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
     * A partir de l'objet qui encapsule le modèle de formulaire de métier on va attribuer les rôles au dit utilisateur.
     * Le modèle de formulaire se composant de 6 attributs qu'on utile pour générer des checkbox de rôles, on va les utiliser pour attribuer les rôles suivant
     * leur valeur.
     * @param int $id : id de l'utilisateur généré.
     * @param CapaUserCreateForm $userForm : modèle de formulaire d'un user.
     */
    static public function setRoles(CapaUserCreateForm $userForm)
    {
        if ($userForm->salary_role_checkbox) self::setRole($userForm->id, UserRoleEnum::SALARY);
        if ($userForm->project_manager_role_checkbox) self::setRole($userForm->id, UserRoleEnum::PROJECT_MANAGER);
        if ($userForm->cellule_manager_role_checkbox) self::setRole($userForm->id, UserRoleEnum::CELLULE_MANAGER);
        if ($userForm->support_role_checkbox) self::setRole($userForm->id, UserRoleEnum::SUPPORT);
        if ($userForm->human_ressources_role_checkbox) self::setRole($userForm->id, UserRoleEnum::HUMAN_RESSOURCES);
        if ($userForm->admin_role_checkbox) self::setRole($userForm->id, UserRoleEnum::ADMIN);
    }

    private static function setRole(int $id, string $role)
    {
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $auth->assign($authorRole, $id);
    }

    /**
     * Retourne vrai si l'utilisateur connecté a le droit passé en paramètre.
     * L'utilité de cette fonction est de pouvoir filtrer l'affichage et l'accès à certaines fonctionnalité en fonction des utilisateurs.
     * @param string $userRole : Utilisation de l'énumération UserRoleEnum.
     * 
     * @return bool Retourne vrai si l'utilisateur a le droit rentré en paramètre, sinon false.
     */
    static function hasRole(string $userRole): bool
    {
        return Yii::$app->user->can($userRole);
    }

    /**
     * Retourne vrai si l'utilisateur connecté a au moins un des droits passés en paramètre.
     * L'utilité de cette fonction est de pouvoir filtrer l'affichage et l'accès à certaines fonctionnalité en fonction des utilisateurs.
     * @param string $userRole : Utilisation de l'énumération UserRoleEnum.
     * 
     * @return bool Retourne vrai si l'utilisateur a au moins un des droits rentrés en paramètre, sinon false.
     */
    static function hasRoles(array $userRoles): bool
    {
        $result = false;
        foreach ($userRoles as $userRole) {
            if (Yii::$app->user->can($userRole)) {
                $result = true;
            }
        }

        return $result;
    }
}
