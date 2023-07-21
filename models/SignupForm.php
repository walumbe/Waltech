<?php 

namespace app\models;
use Webpatser\Uuid\Uuid;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\VarDumper;

class Signup extends Model
{
    public $username;
    public $password;
    public $password_confirm;

    public function rules()
    {
        return [
            [['username', 'password', 'password_confirm' ], 'required'],
            [['username'], 'string', 'min' => 3, 'max' => 16 ],
            [['password'], 'min'=> 6],
            [['password_confirm'], 'compare', 'compareAttribute' => 'password']
        ];
    }

    public function signUp()
    {
        $user = new User();
        $user->id = Uuid::generate()->string;
        $user->username = $this->username;
        $user->password = \Yii::$app->security->generatePasswordHash($this->password);

        if($user->save(false))
        {
            return true;
        } 
        \Yii::error('User was not saved', VarDumper::dumpAsString($user->errors));

        return false;
    }
}