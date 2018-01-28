<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Visitors extends ActiveRecord
{
    public function rules()
	{
	    return [
			[['username', 'phone_number', 'minutes', 'visit_price'], 'required'],
			['username', 'validateUsername'],
	        [['username'], 'string', 'max' => 45],
			['phone_number','validatePhoneNumber'],
			['phone_number', 'string', 'length' => 13],
			[['minutes'],'number', 'max' => 720, 'min' => 30],
			[['visit_price'], 'number', 'min' => 0],
	    ];
	}

	public function addVisitor($city_id) 
	{
		$this->exit_time = date("H:i:s", time()+7200 +  $this->minutes*60);
		$this->city_id = $city_id;
		$clients = Clients::findOne(['username' => $this->username, 'phone_number'=> $this->phone_number]);
		if(isset($clients)){
			$clients->bonus += $this->minutes*0.1;
			$clients->last_visit_day = date("Y-m-d");
			$clients->save();
			$this->bonus = $clients->bonus;
		} else {
			$this->bonus = 0;
		}
		$this->save();
	}

	public function clearVisitors() 
	{
		Yii::$app->db->createCommand()->truncateTable('visitors')->execute();
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
?>