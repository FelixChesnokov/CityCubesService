<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class VisitorsBonus extends ActiveRecord
{
    public function rules()
	{
	    return [
			[['username', 'phone_number'], 'required'],
			['username', 'validateUsername'],
	        [['username'], 'string', 'max' => 45],
			['phone_number','validatePhoneNumber'],
			['phone_number', 'string', 'length' => 13],
	    ];
	}

	public static function tableName()
    {
        return '{{visitors}}';
    }

	public function deleteBonus($visitorBonus, $clientBonus)
	{
		$visitorBonus->exit_time = date("H:i:s", strtotime($visitorBonus->exit_time) + $visitorBonus->bonus*60); // bonus time(min) 
		$visitorBonus->bonus = 0;
		$visitorBonus->save();
		$clientBonus->bonus = 0;
		$clientBonus->save();
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