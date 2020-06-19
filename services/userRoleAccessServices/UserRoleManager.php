<?php

namespace app\services\userRoleAccessServices;

use app\models\users\CapaUserCreateForm;
use app\models\users\CapaUserUpdateForm;
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
     * A partir de l'objet qui encapsule le modèle de formulaire de création, on va attribuer les rôles au dit utilisateur.
     * Le modèle de formulaire se composant de 6 attributs qu'on utile pour générer des checkbox de rôles, on va les utiliser pour attribuer les rôles suivant
     * leur valeur.
     * @param int $id : id de l'utilisateur généré.
     * @param CapaUserCreateForm $userForm : modèle de formulaire d'un user.
     */
    static function setRolesFromUserCreateForm(CapaUserCreateForm $userForm)
    {
        if ($userForm->salary_role_checkbox) self::setRole($userForm->id, UserRoleEnum::SALARY);
        if ($userForm->project_manager_role_checkbox) self::setRole($userForm->id, UserRoleEnum::PROJECT_MANAGER);
        if ($userForm->cellule_manager_role_checkbox) self::setRole($userForm->id, UserRoleEnum::CELLULE_MANAGER);
        if ($userForm->support_role_checkbox) self::setRole($userForm->id, UserRoleEnum::SUPPORT);
        if ($userForm->human_ressources_role_checkbox) self::setRole($userForm->id, UserRoleEnum::HUMAN_RESSOURCES);
        if ($userForm->admin_role_checkbox) self::setRole($userForm->id, UserRoleEnum::ADMIN);
    }

    /**
     * A partir de l'objet qui encapsule le modèle de formulaire de modification, on va attribuer les rôles au dit utilisateur.
     * Le modèle de formulaire se composant de 6 attributs qu'on utile pour générer des checkbox de rôles, on va les utiliser pour attribuer les rôles suivant
     * leur valeur.
     * @param int $id : id de l'utilisateur généré.
     * @param CapaUserCreateForm $userForm : modèle de formulaire d'un user.
     */
    static function setRolesFromUserUpdateForm(CapaUserUpdateForm $userForm)
    {
        if ($userForm->salary_role_checkbox) self::setRole($userForm->id, UserRoleEnum::SALARY);
        if ($userForm->project_manager_role_checkbox) self::setRole($userForm->id, UserRoleEnum::PROJECT_MANAGER);
        if ($userForm->cellule_manager_role_checkbox) self::setRole($userForm->id, UserRoleEnum::CELLULE_MANAGER);
        if ($userForm->support_role_checkbox) self::setRole($userForm->id, UserRoleEnum::SUPPORT);
        if ($userForm->human_ressources_role_checkbox) self::setRole($userForm->id, UserRoleEnum::HUMAN_RESSOURCES);
        if ($userForm->admin_role_checkbox) self::setRole($userForm->id, UserRoleEnum::ADMIN);
    }

    /**
     * Méthode privée pour attribuer un role plus rapidement.
     */
    private static function setRole(int $id, string $role)
    {
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $auth->assign($authorRole, $id);
    }

    /**
     * Fonction utilisée pour associer les rôles de l'utilisateur aux valeurs des checkbox que l'on va générer dans la vue de modification.
     */
    static function setRoleToModelForm(CapaUserUpdateForm $model)
    {
        $userRoles = self::getUserRoles($model->id);
        if (in_array(UserRoleEnum::SALARY, $userRoles)) $model->salary_role_checkbox = true;
        if (in_array(UserRoleEnum::PROJECT_MANAGER, $userRoles)) $model->project_manager_role_checkbox = true;
        if (in_array(UserRoleEnum::CELLULE_MANAGER, $userRoles)) $model->cellule_manager_role_checkbox = true;
        if (in_array(UserRoleEnum::SUPPORT, $userRoles)) $model->support_role_checkbox = true;
        if (in_array(UserRoleEnum::HUMAN_RESSOURCES, $userRoles)) $model->human_ressources_role_checkbox = true;
        if (in_array(UserRoleEnum::ADMIN, $userRoles)) $model->admin_role_checkbox = true;
    }

    /**
     * Fonction assez lourde (donc possiblement à améliorer, voir la mettre autre part car elle n'a pas sa place dans une vue) qui permet de déterminé si l'utilisateur
     * peut être connecté par la personne connecté.
     */
    static function canUpdateUser($userRoles): bool
    {
        $result = true;

        if (
            UserRoleManager::hasRoles([UserRoleEnum::SUPER_ADMIN])
            || UserRoleManager::hasRoles([UserRoleEnum::ADMIN])
            || !UserRoleManager::hasRoles([UserRoleEnum::HUMAN_RESSOURCES])
        ) {

            if (
                (UserRoleManager::hasRoles([UserRoleEnum::ADMIN]) || UserRoleManager::hasRoles([UserRoleEnum::HUMAN_RESSOURCES]))
                &&
                (in_array(UserRoleEnum::SUPER_ADMIN, $userRoles) || in_array(UserRoleEnum::ADMIN, $userRoles))
            ) $result = false;

            if (
                UserRoleManager::hasRoles([UserRoleEnum::SUPER_ADMIN])
                &&
                in_array(UserRoleEnum::SUPER_ADMIN, $userRoles)
            ) $result = false;
        } else {
            $result = false;
        }

        return $result;
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
