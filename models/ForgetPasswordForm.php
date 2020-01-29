<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ForgetPasswordForm extends Model
{
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            ['email', 'required', 'message' => 'L\'adresse email ne peut être vide.'],
            ['email', 'email', 'message' => 'L\'adresse email doit être valide.']
        ];
     
    }


    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function generatednewpassword()
    {

        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom('juien.viaud@capacites.fr')
                ->setSubject('mot de passe')
                ->setTextBody('winner')
                ->send();

            return true;
        }
        return false;
    }
    
}
