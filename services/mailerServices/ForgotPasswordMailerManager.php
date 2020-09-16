<?php

namespace app\services\mailerServices;

use app\models\users\CapaUser;
use Yii;

class ForgotPasswordMailerManager
{

    /**
     * Permet d'envoyer un mail avec un lien pour changer le mot de passe d'un utilisateur
     * Modifie la base de données (Table User) en ajoutant un flag au compte modifié et un tag
     * 
     * @param CapaUser $capaUser - Utilisateur dont le mot de passe vient d'être modifié.
     * @param string $newPassword - Le nouveau mot de passe.
     */
    public static function sendResetPasswordSimpleMail(?CapaUser $capaUser, string $newPassword)
    {
        $message = "<span style=\"font-family: Courier;\">Bonjour, " . $capaUser->firstname . ' ' . $capaUser->surname . " "
            . "<br /> Test";
        $message .= "Votre nouveau mot de passe est le suivant : " . $newPassword;

        $headers =  "From: \"Capatools\"<noreply@capatools.fr>\n"; // Expéditeur
        $headers .= "Content-type: text/html; charset=\"utf-8\""; // Encodage en HTML et UTF-8
        return mail($capaUser->email, "Mot de passe oublié", $message, $headers); // Envoi du mail
    }

    /**
     * Permet d'envoyer un mail avec un lien pour changer le mot de passe d'un utilisateur
     * Modifie la base de données (Table User) en ajoutant un flag au compte modifié et un tag
     * Attention, cette fonction n'est pas du tout fonctionnelle, ne pas l'utiliser avant une mise à jour de celle-ci.
     * 
     * @param CapaUser $capaUser - Utilisateur dont le mot de passe vient d'être modifié.
     * @param string $newPassword - Le nouveau mot de passe.
     */
    public static function sendResetPasswordMail(?CapaUser $capaUser, string $newPassword)
    {

        if ($capaUser == null) return false;

        ini_set('display_errors', 1);
        error_reporting(E_ALL);

        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $capaUser->email)) {
            $passage_ligne = "\r\n";
        } else {
            $passage_ligne = "\n";
        }

        $boundary = "-----=" . md5(rand());
        $subject = "Mot de passe oublié";

        //HEADER MESSAGE
        $header = "From:" . Yii::$app->params['senderEmail']  . $passage_ligne;
        $header .= "Reply-to:" . $capaUser->email . $passage_ligne;
        $header .= "MIME-Version: 1.0" . $passage_ligne;
        $header .= "Content-Type: multipart/alternative;" . $passage_ligne . " boundary=\"$boundary\"" . $passage_ligne;

        //BODY MESSAGE
        $message_html = "<h4>Mot de passe réinitialisé</h4>";
        $message_html .= "Votre nouveau mot de passe est le suivant : " . $newPassword;
        $message = $passage_ligne . "--" . $boundary . $passage_ligne;
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $passage_ligne;
        $message .= "Content-Transfer-Encoding: 8bit" . $passage_ligne;
        $message .= $passage_ligne . $message_html . $passage_ligne;

        $message .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;
        $message .= $passage_ligne . "--" . $boundary . "--" . $passage_ligne;

        return mail($capaUser->email, $subject, $message, $header);
    }
}
