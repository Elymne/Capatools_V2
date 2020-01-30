<?php

namespace app\models\login;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class FirstConnexion extends Model
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
            ['newpassword', 'required', 'message' => 'Veulliez renseigner un nouveau mot de passe']   ,
            ['confirmationpassword', 'required', 'message' => 'Veulliez confirmer le nouveau mot de passe']   ,
           // password is validated by validatePasseword()
            ['newpassword', 'validatePasseword'],
            // password is validated by validateConfirmatedPasseword()
            ['confirmationpassword', 'validateConfirmatedPasseword'],
        ];
     
    }

    /**
     * Validates the email.
     * This method serves as the inline validation for email.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUserMail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = Capaidentity::findByemail($this->email);

            if (!$user) {
                $this->addError($attribute, 'l\'adresse email est inconnue');
            }

        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function generatednewpassword()
    {

        if ($this->validate()) {
            
            $user = Capaidentity::findByemail($this->email);
            $Newpassword = $user->generatePasswordResetPassord();
            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject('mot de passe')
                ->setTextBody('Le nouveau mdp : '. $Newpassword)
                ->send();

            return true;
        }
        return false;
    }
    
}
