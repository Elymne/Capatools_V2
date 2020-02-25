<?php

namespace app\models\user;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class CapaUser extends ActiveRecord  implements IdentityInterface
{

    private $celluleName;
    public static function tableName()
    {
        return 'capa_user';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            // email required
            ['email', 'required', 'message' => 'Veulliez renseigner l\'email de l\'utilisateur'],
            ['username', 'required', 'message' => 'Veulliez renseigner le nom de l\'utilisateur'],
            ['cellule_id', 'required', 'message' => 'Veulliez selectionner la cellule de l\'utilisateur'],
            ['email', 'email', 'message' => 'L\'adresse email doit être valide.'],
            ['cellule_id', 'validateCelid', 'message' => 'Le nom de la cellule est inconnue'],
        ];
    }

    public function validateCelid($param)
    {
        if (!Cellule::find()->where(['id' => $this->cellule_id])->exists()) {

            //$this->addError($attribute, 'la cellule n\'existe pas');
            // What is $attribute ? It's undefinded.

        }
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
     * Trouve une identité à partir de l'identifiant donné.
     *
     * @param string|int $id l'identifiant à rechercher
     * @return username|null l'objet identité qui correspond à l'identifiant donné
     */
    public static function findByUsername($name)
    {
        return static::findOne(['username' => $name]);
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
     * Generates new password
     * @return string le nouveau password
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
    /**
     * Generates new password
     * @return string le nouveau password
     */
    public function generatePassword()
    {
        //Generate le nouveau mot de passe de 12 characteres
        $Newpassword = Yii::$app->getSecurity()->generateRandomString(12);

        $this->flag_password = true;

        //Save Hash du nouveau password
        $this->SetNewPassword($Newpassword);

        return $Newpassword;
    }

    /**
     * Sauvegarde le hash du nouveau password
     * @param string $password le mot de passe
     */
    public function SetNewPassword($password)
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

    public function getUserRole()
    {

        return $this->hasMany(UserRole::className(), ['user_id' => 'id']);
    }

    public function getCellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'cellule_id']);
    }
}
