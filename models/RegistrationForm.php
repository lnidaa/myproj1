<?php
/**
 * Created by PhpStorm.
 * User: Dashok
 * Date: 19.02.2018
 * Time: 14:14
 */

namespace app\models;
use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
   public $name;
   public $surname;
    public $username;
    public $password;
    public $id_role;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['name', 'required'],
            ['surname', 'required'],
            ['id_role', 'number'],
            ['username', 'string', 'min' => 2, 'max' => 20],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {


        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->surname = $this->surname;
        $user->password=$this->password;
        $user->id_role=$this->id_role;
        return $user->save();
    }

}