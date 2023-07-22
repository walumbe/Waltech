<?php 

namespace app\models;
use Webpatser\Uuid\Uuid;
use yii\base\Model;
use yii\helpers\VarDumper;

class SignupForm extends Model
{
    public $username;
    public $password;
    public $password_confirm;

    public function rules()
    {
        return [
            [['username', 'password' ], 'required'],
            ['username', 'string', 'min' =>3, 'max' =>12 ],
            ['password', 'string', 'min'=>6],
            ['password_confirm', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function signUp()
    {
        $user = new User();
        $user->id = Uuid::generate()->string;
        $user->username = $this->username;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);
        $user->auth_key = \Yii::$app->security->generateRandomString();
        $user->access_token = \Yii::$app->security->generateRandomString();

        if($user->save(false))
        {
            return true;
        } 
        \Yii::error('User was not saved', VarDumper::dumpAsString($user->errors));

        return false;
    }

}