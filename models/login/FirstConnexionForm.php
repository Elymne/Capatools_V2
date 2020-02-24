<?php

namespace app\models\login;

use Yii;
use yii\base\Model;

use app\models\user\Capaidentity;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
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
     */
    public function SaveNewpassword()
    {
        if ($this->validate()) {

            $capuser =  Yii::$app->user->getIdentity();
            //J'enregistre le nouveau password
            $capuser->SetNewPassword($this->newpassword);
            //Je met que le passeword a été regénéré
            $capuser->flagPassword = false;
            $capuser->save();


            return true;
        }
        return false;
    }
}
