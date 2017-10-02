<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property integer $uid
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 *
 * @property Album[] $albums
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'password'], 'required'],
            [['name'], 'string'],
            ['password','string','min'=>8],
            [['email'], 'string', 'max' => 100],
            ['email','email'],
            ['phone','number'],
            [['phone'], 'string', 'max' => 11,'min'=>10],
            [['phone'], 'unique'],
            [['email'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->uid;
    }

    public function getAuthKey()
    {
        //  return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public function validatePassword($password)
    {
        return $this->password === $password;
    }


    public static function findByUsername($username)
    {
        return self::findOne(['email' => $username]);
    }

    public static function findByPhno($username)
    {
        return self::findOne(['phone'=>$username]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbums()
    {
        return $this->hasMany(Album::className(), ['uid' => 'uid']);
    }
}
