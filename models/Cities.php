<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Cities extends ActiveRecord
{
    public function rules()
	{
	    return [
			[['city'], 'required'],
			[['city'], 'string', 'max' => 45],
			['city', 'validateCity'],
	    ];
	}
	
	public function getEmployees() 
	{
		return $this->hasMany(Employees::className(), ['city_id' => 'id']);
	}

	public function getUser() 
	{
		return $this->hasOne(User::className(), ['city_id' => 'id']);
	}

	public function selectEmployeeByCity() 
	{
		return $AllEmployeesManage = $this->city == ''
		? Employees::find()->with(['cities'])->all()
		: Employees::find()->where(['city_id'=> $this->city])->with(['cities'])->all();
	}

	public function validateCity($attribute, $params)
	{
		$pattern = "/^([а-яА-ЯЁё.\s]+)$/u";
		if(!preg_match($pattern, $this->city)){
			$this->addError($attribute, 'Incorrect City');
		}
	}
}
?>

