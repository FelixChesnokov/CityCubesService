<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Clients extends ActiveRecord
{
    public function rules()
	{
	    return [
			[['username', 'phone_number', 'is_parent'], 'required'],
			['username', 'validateUsername'],
			[['username'], 'string', 'max' => 45],
			['birthday', 'validateDate'],
			[['phone_number'],'validatePhoneNumber'],
			['phone_number', 'string', 'length' => 13],
			['email', 'email'],
			['is_parent', 'required'],
	    ];
	}
	
	public function addClients($city_id)
	{
		if($this->is_parent == '1'){
			$this->is_parent = true;
			$this->bonus = 0;
		} else {
			$this->is_parent = false;
		}
		$this->city_id = $city_id;
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

	public function validateDate($attribute, $params)
	{
		if($this->birthday > date("Y-m-d")){
			$this->addError($attribute, 'Incorrect date');
		}
	}
}
?>