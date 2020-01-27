<?php

namespace app\models;
use Yii;
use yii\base\Security;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Capaidentity extends ActiveRecord  implements IdentityInterface
{

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

    public function getRights()
    {
        
        //return $this->hasMany(Rights::className(), ['Userid' => 'id']);
    }


}

