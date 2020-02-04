<?php

namespace app\models\login;

use Yii;
use yii\base\Model;

use app\models\User\Capaidentity;
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
            ['email', 'email', 'message' => 'L\'adresse email doit être valide.']   ,
           // email is validated by validateUserMail()
            ['email', 'validateUserMail'],
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
            $Newpassword = $user->generatePassword();
            $user->save();
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
