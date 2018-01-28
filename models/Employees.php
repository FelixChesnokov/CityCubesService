<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Employees extends ActiveRecord
{
    public function rules()
	{
	    return [
			[['username', 'phone_number'], 'required'],
			['username', 'validateUsername'],
			[['username'], 'string', 'max' => 45],
			['phone_number','validatePhoneNumber'],
			['phone_number', 'string', 'length' => 13],
			['id', 'safe'],
	    ];
	}

	public function getCities()
	{
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
	}
	
	public function deleteBonus()
	{
		$this->bonus = 0;
		$this->save();
	}

	public function addCurrentTime()
	{
		return date("H:i:s", time()+7200);
	}

	public function AddEmployeesBonus($AllEmployeesWorked, $AllVisitors, $city_id, $employee_bonus) 
	{
		foreach($AllEmployeesWorked as $employeesWorked){
		//	Search employee which worked when visitor was
			$endWork = $employeesWorked->end_work;
			$employeesWorkedBonus = 0;
			$AllVisitors = Visitors::find()
				->where(['city_id' => $city_id])
				->andwhere(['<', 'exit_time', $endWork])
				->all();
		//	Create employee bonus
			foreach($AllVisitors as $visitor){
				$employeesWorkedBonus += $visitor->minutes/60*$visitor->visit_price;
			}
		//  Save employee bonus	
			$employeesWorked->bonus += $employeesWorkedBonus*$employee_bonus*0.01;	
			$employeesWorked->start_work = NULL;
			$employeesWorked->end_work = NULL;
			$employeesWorked->save();
		}
		// Delete variables
		foreach($AllVisitors as $visitor){
			$visitor->minutes = 0;
			$visitor->save();
		}
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