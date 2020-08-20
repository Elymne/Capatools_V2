<?php

namespace app\models\users;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Classe modèle métier des utilisateurs.
 * Permet de faire des requêtes depuis la table capa_user de la db associé à l'app.
 * Marche de la même manière qu'un ORM (voir la fonction getAll par l'exemple).
 * 
 * Cette classe implémente l'interface IDentityInterface qui permet de gérer les utiliseurs et la sécurité à la manière de Yii2.
 * 
 * @version Capatools v2.0
 * @since Classe existante depuis la Release v2.0
 */
class CapaUser extends ActiveRecord  implements IdentityInterface
{

    public static function tableName()
    {
        return 'capa_user';
    }

    /**
     * Trouve une identité à partir de l'identifiant donné.
     *
     * @param string|int $id l'identifiant à rechercher
     * @return IdentityInterface|null l'objet identité qui correspond à l'identifiant donné
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Trouve une identité à partir de l'email donné.
     *
     * @param string|int $email de l'identifiant à rechercher
     * @return username|null l'objet identité qui correspond à l'email donné
     */
    public static function findByemail($email)
    {
        return static::findOne(['email' => $email]);
    }

    /**
     * Trouve une identité à partir du jeton donné
     *
     * @param string $token le jeton à rechercher
     * @return IdentityInterface|null l'objet identité qui correspond au jeton donné
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string l'identifiant de l'utilisateur courant
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string la clé d'authentification de l'utilisateur courant
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Generates new password and mails
     */
    public function generatePasswordAndMail()
    {
        $Newpassword = $this->generatePassword();
        $this->save();
        Yii::$app->mailer->compose()
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject('mot de passe')
            ->setTextBody('Le nouveau mdp : ' . $Newpassword)
            ->send();
    }

    public function getfullName()
    {
        return $this->firstname . " " . $this->surname;
    }



    /**
     * Generates new password
     * @return string le nouveau password
     */
    public function generatePassword()
    {
        //Generate le nouveau mot de passe de 12 characteres
        $newPassword = Yii::$app->getSecurity()->generateRandomString(12);

        $this->flag_password = true;

        //Save Hash du nouveau password
        $this->setNewPassword($newPassword);

        return $newPassword;
    }

    /**
     * Sauvegarde le hash du nouveau password
     * @param string $password le mot de passe
     */
    public function setNewPassword($password)
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * @param string $authKey
     * @return bool si la clé d'authentification est valide pour l'utilisateur courant
     */
    public function validateAuthKey($authKey)
    {
        $bresultat = false;
        $userAuthkey = $this->getAuthKey();
        if ($userAuthkey === $authKey) {
            if ($userAuthkey == $authKey) {
                $bresultat = true;
            }
        }
        return $bresultat;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($pass)
    {
        //$this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($pass);
        // echo $this->password_hash;
        return Yii::$app->getSecurity()->validatePassword($pass, $this->password_hash);
    }

    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }

    /**
     * @deprecated
     * Fonction inutile pour l'instant, je ne connais pas son but.
     */
    public function validateCelid($param)
    {
        if (!Cellule::find()->where(['id' => $this->cellule_id])->exists()) {

            //$this->addError($attribute, 'la cellule n\'existe pas');
            // What is $attribute ? It's undefinded.
        }
    }
}
