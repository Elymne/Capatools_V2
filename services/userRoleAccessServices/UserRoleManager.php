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
     * Récupère tous les droits d'un utilisateur depuis son id.
     * @param int $id : identifiant utilisateur.
     * 
     * @return array La liste de string de tous les rôles de l'utilisateur.
     */
    static function getUserRoles(int $id): array
    {
        return array_map(function ($userRole) {
            return $userRole->roleName;
        }, Yii::$app->authManager->getAssignments($id));
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
     * A partir de l'objet qui encapsule le modèle de formulaire de création d'un utilisateur, on va attribuer les rôles au dit utilisateur.
     * Le modèle de formulaire se composant de 6 attributs qu'on utile pour générer des checkbox de rôles, on va les utiliser pour attribuer les rôles suivant
     * leur valeur.
     * Le type des attributs régissant les checkbox est un boolean.
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
     * Le type des attributs régissant les checkbox est un boolean.
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
     * Méthode privée pour attribuer un rôle plus rapidement.
     * @param int $id, id utilisateur.
     * @param string $role, la chaîne de caractère représentant le rôle (UTILISEZ LA CLASSE D'ENUMERATION).
     */
    private static function setRole(int $id, string $role)
    {
        $auth = \Yii::$app->authManager;
        $authorRole = $auth->getRole($role);
        $auth->assign($authorRole, $id);
    }

    /**
     * On utilise cette fonction pour définir les valeur des boolean de chaque combobox dans le modèle de formulaire fournit en paramètre.
     * On mute donc les valeurs de l'objet $model qu'on a instancié (pas très programmation fonctionnel hélas).
     * @param CapaUserUpdateForm $model, un modèle de formulaire qui sert à modifier des utilisateurs.
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
     * Fonction assez lourde qui permet en réalité de déterminer si l'utilisateur connecté peut modifier un utilisateur spécifique.
     * La fonction est mal conçu dans le sens où elle ne prend en paramètre, pas un objet User mais bien les rôles d'un user.
     * En gros, pour utiliser cette fonction dans une vue ou un contrôleur, on récupère un utilisteur, on récupère ses rôles 
     * puis ont les utilises dans cette fonction pour voir si on à le droit de modifier l'utilisateur en question.
     * 
     * Cela permet qu'un admin ne puisse pas modifier un autre admin ou un super-admin.
     * Qu'un support ne puisse pas modifier un autre support ou un admin ou un super-admin.
     * 
     * @param array $userRoles, la liste des rôles d'un utilisateur.
     * 
     * @return bool
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
     * @param string $userRole, Utilisation de l'énumération UserRoleEnum.
     * 
     * @return bool, retourne vrai si l'utilisateur a le droit rentré en paramètre, sinon false.
     */
    static function hasRole(string $userRole): bool
    {
        return Yii::$app->user->can($userRole);
    }

    /**
     * Retourne vrai si l'utilisateur connecté a au moins un des droits passés en paramètre.
     * L'utilité de cette fonction est de pouvoir filtrer l'affichage et l'accès à certaines fonctionnalité en fonction des utilisateurs.
     * @param string $userRole, utilisation de l'énumération UserRoleEnum.
     * 
     * @return bool, retourne vrai si l'utilisateur a au moins un des droits rentrés en paramètre, sinon false.
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
