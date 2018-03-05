<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $name
 * @property string $surname
 * @property string $username
 * @property string $password
 * @property int $id_role
 * @property int $id_user
 * @property string $auth_key
 * @property string $access_token
 */
class UserIdentity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'password'], 'required'],
            [['name', 'username', 'password'], 'string', 'max' => 20],
            [['surname'], 'string', 'max' => 50],
            [['id_role'], 'number', 'max' => 4],
            [['auth_key', 'access_token'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'surname' => 'Surname',
            'username' => 'Username',
            'password' => 'Password',
            'id_role' => 'Id Role',
            'id_user' => 'Id User',
            'auth_key' => 'Auth Key',
            'access_token' => 'Access Token',
        ];
    }
}
