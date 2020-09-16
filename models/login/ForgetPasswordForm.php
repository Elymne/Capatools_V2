<?php

namespace app\models\login;

use Yii;
use yii\base\Model;
use app\models\users\CapaUser;
use app\services\mailerServices\ForgotPasswordMailerManager;

/**
 * Classe permettant de créer un formulaire relatif à l'oubli de mot de passe.
 * //TODO classe inchangé depuis la génération du projet, à revoir.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
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
            ['email', 'required', 'message' => 'L\'adresse email ne peut être vide.'],
            ['email', 'email', 'message' => 'L\'adresse email doit être valide.'],
            ['email', 'validateUserMail'],
        ];
    }

    /**
     * Validates the email.
     * This method serves as the inline validation for email.
     */
    public function validateUserMail($attribute, $params)
    {
        if (CapaUser::findByEmail($this->email) == null) {
            $this->addError($attribute, 'l\'adresse email est inconnue');
        }
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email - the target email address
     * 
     * @return bool - whether the model passes validation
     */
    public function generateNewPassword(): bool
    {
        if ($this->validate()) {

            $capaUser = CapaUser::findByEmail($this->email);
            $newPassword = $capaUser->generatePassword();

            if ($capaUser->save()) {
                return (ForgotPasswordMailerManager::sendResetPasswordSimpleMail($capaUser, $newPassword));
            }
        }
        return false;
    }
}
