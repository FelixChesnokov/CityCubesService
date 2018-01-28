<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public function rules()
	{
	    return [
            [['username', 'phone_number', 'password', 'employee_bonus'], 'required'],
            ['username', 'validateUsername'],
	        [['username'], 'string', 'max' => 45],
			[['phone_number'],'validatePhoneNumber'],
            ['phone_number', 'string', 'length' => 13],
            [['employee_bonus'],'number', 'max' => 100, 'min' => 1],
	    ];
    }

    public function getRevenues()
    {
        return $this->hasMany(Revenues::className(), ['user_id' => 'id']);
    }

    public function getCities()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
//            isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
//        foreach (self::$users as $user) {
//            if ($user['accessToken'] === $token) {
//                return new static($user);
//            }
//        }
//
//        return null;
        
        return static::findOne(['access_token'=> $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username'=> $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
       return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }
    
    
     public function afterLogin($event)
    {
        $this->lastvisitDate = date('Y-m-d H:i:s');
        $this->save(false);
        return true;
    }

    public function addBonusKoef($searchUser) 
    {
        $searchUser->employee_bonus = $this->employee_bonus;
        $searchUser->save();
    }

    public function addUsers($currentCity)
    {
        $this->city_id = $currentCity->id;
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
        $this->save(); 
    }

    public function validateUsername($attribute, $params)
	{
		$pattern = "/^([а-яА-ЯЁё.\s]+)$/u";
		if(!preg_match($pattern, $this->username)){
			$this->addError($attribute, 'Incorrect username');
		}
    }
    
    public function validatePhoneNumber($attribute, $params)
	{
		$pattern = "/^\+380\d{3}\d{2}\d{2}\d{2}$/";
		if(!preg_match($pattern, $this->phone_number)){
			$this->addError($attribute, 'Incorrect phone number');
		}
	}
}
