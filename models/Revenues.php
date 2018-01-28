<?php
namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Revenues extends ActiveRecord
{
    public function rules()
	{
	    return [
			[['user_id', 'revenue'], 'required'],
	    ];
	}

	public function getUser()
	{
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

	public function selectRevenueByUser()
	{
		return $AllRevenues = $this->user_id != ''
		? Revenues::find()->where(['user_id'=> $this->user_id])->with(['user.cities'])->all()
		: null;
	}

	public function beforeSave($insert)
	{
		$this->date = date("Y-m-d");
		return isset($this->date);
	}

	public function AddRevenue($AllVisitors, $city_id, $user_id)
	{
		$this->user_id = $user_id;
		foreach ($AllVisitors as $visitor){
			$this->revenue += $visitor->minutes*100/60;
		}
		$this->save();
	}
}
?>