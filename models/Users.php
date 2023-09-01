<?php

namespace app\models;

use Yii;
use app\models\Firm;
use app\models\Resume;


/**
 * This is the model class for table "Users".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $company
 * @property string $phone
 * @property string $city
 * @property string $email
 * @property string $password
 * @property int $type
 * @property string $recover_code
 * @property int $create_time
 * @property string $auth_key
 * @property string $access_token
 */
class Users extends \yii\db\ActiveRecord
{
    public function rules()
    {
        return [
            [['name', 'email','phone','password','location','site','director','contact','auth_key','inn','url'], 'safe'],
        ];
    }
 
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'company' => 'Компания',
            'phone' => 'Телефон',
            'email' => 'Email',
            'password' => 'Пароль',
            'auth_key' => 'Ключ входа',
            'director' => 'Директор',
            'phone' => 'Телефон',
            'inn' => 'ИНН',
            'location' => 'Локация',
            'site' => 'Сайт',
            'contact' => 'Контактное лицо',
            'isadmin' => 'Администратор',

        ];
    }
    
    
    public function getFirm()
    {
        return $this->hasOne(Firm::class, ['id' => 'firm_id']);
    }
    
    public function beforeDelete(){
       
        return parent::beforeDelete();
    }
}
