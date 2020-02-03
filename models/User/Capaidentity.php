<?php

namespace app\models\User;
use Yii;
use yii\base\Security;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\data\ActiveDataProvider;
use yii\base\Model;
class Capaidentity extends ActiveRecord  implements IdentityInterface
{


    public static function tableName()
    {
        return 'Capaidentity';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

        ];
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
    public function generatePasswordResetPassord()
    {
        //Generate le nouveau mot de passe de 12 characteres
        $Newpassword = Yii::$app->getSecurity()->generateRandomString(12) ;

        $this->flagPassword = true;

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
        $userAuthkey = $this->getAuthKey() ;
        if( $userAuthkey === $authKey)
        {
            if($userAuthkey == $authKey)
            {
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

    
    public function getuserrightapplication()
    {
        
        return $this->hasMany(userrightapplication::className(), ['Userid' => 'id']);
    }

    public function getcellule()
    {
        return $this->hasOne(Cellule::className(), ['id' => 'Celluleid']);
    }


}

