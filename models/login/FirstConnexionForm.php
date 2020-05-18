<?php

namespace app\models\login;

use Yii;
use yii\base\Model;

/**
 * //TODO cette classe n'est pas utilisé dans l'app pour l'instant, revoir son utilité dans le futur.
 * Classe permettant de gérer le formulaire du login.
 * Celle-ci permet de créer un formulaire de création de devis et de vérifier la validité des données inscrites dans les champs.
 * Elle permet aussi lorsque l'on veut créer un formulaire pour créer un devis, d'ajouter des champs qui n'existe pas dans la bdd.
 * 
 * Cette classe est a utiliser lorsque vous voulez créer une vue avec un formulaire depuis le contrôleur (contrôleur Devis ici).
 * ex : upfilename, pathfile, datept.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 * @deprecated
 */
class FirstConnexionForm extends Model
{
    public $password;
    public $newpassword;
    public $confirmationpassword;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['password', 'required', 'message' => 'Veulliez renseigner l\'ancien mot de passe'],
            ['newpassword', 'required', 'message' => 'Veulliez renseigner un nouveau mot de passe'],
            ['confirmationpassword', 'required', 'message' => 'Veulliez confirmer le nouveau mot de passe'],
            // password is validate par une expression réguilière en obligeant l'utilisateur à créer un mot de passe
            // d'au moins 8 caractères , contenant une minuscule, une majuscule, un chiffre et un caractère spécial
            ['newpassword', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).{8,}$/', 'message' => 'Le mot de passe doit contenir au moins 8 caractères dont une minuscule, 
                                                                                                        une majuscule, un chiffre et un caractère spécial.'],
            // Compare les deux champs passwords
            ['confirmationpassword', 'compare', 'compareAttribute' => 'newpassword', 'message' => 'Le mot de passe doit être idententique au nouveau mot de passe.'],
        ];
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     * @deprecated
     */
    public function SaveNewpassword()
    {
        if ($this->validate()) {

            $capuser = Yii::$app->user->getIdentity();
            //J'enregistre le nouveau password
            $capuser->SetNewPassword($this->newpassword);
            //Je met que le passeword a été regénéré
            $capuser->flag_password = false;
            $capuser->save();


            return true;
        }
        return false;
    }
}
