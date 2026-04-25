<?php

namespace app\models;

use Symfony\Component\VarDumper\VarDumper;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $full_name;
    public $login;
    public $email;
    public $password;
    public $phone;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['full_name', 'login', 'password', 'email', 'phone'], 'required'],
            [['full_name', 'login', 'password', 'email', 'phone'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 8],
            [['login'], 'string', 'min' => 6],
            [['email'], 'email'],
            // ['login', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'логин должен сожержать латиницу и цифры, не менее 6 символов'],
            ['login', 'match', 'pattern' => '/^[a-z\d]+$/', 'message' => 'логин должен сожержать латиницу и цифры, не менее 6 символов'],
            
            ['full_name', 'match', 'pattern' => '/^[а-яё\s]+$/iu', 'message' => 'ФИО должно содержать символы кириллицы и пробелы'],

            ['phone', 'match', 'pattern' => '/^8\([\d]{3}\)[\d]{3}(\-[\d]{2}){2}$/', 'message' => 'телефон (формат: 8(XXX)XXX-XX-XX)'],
            // 8\([\d{3}]\)[\d]{3}\-[\d]{2}\-[\d]{2}

            // [ 'login', 'match', 'pattern' => '/^[a-z\d]+$/i'],
            [['login'], 'unique', 'targetClass' => User::class],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'full_name' => 'ФИО',
            'login' => 'Логин',
            'password' => 'Пароль',
            'email' => 'Почта',
            'phone' => 'Номер телефона',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function register(): User | bool
    {
        if ($this->validate()) {
   	        $user = new User();
   	        $user -> load($this->attributes, '');
   	        $user -> password = Yii::$app->security->generatePasswordHash($user->password);
            $user -> auth_key = Yii::$app->security->generateRandomString();
            if (!$user->save()){
                VarDumper::dump($user->errors, 10, true);
                die;
            }
           
        }
        return $user ?? false;
    }
}
