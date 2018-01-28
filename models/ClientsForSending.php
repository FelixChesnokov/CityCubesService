<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class ClientsForSending extends ActiveRecord
{
    public $messageText;

    public function rules()
	{
	    return [
            ['last_visit_day', 'validateLastVisitDay'],
            ['messageText', 'string', 'max' => 70, 'min'=>5],
	    ];
    }
    
    public static function tableName()
    {
        return '{{clients}}';
    }

	public function validateLastVisitDay($attribute, $params)
	{
		if($this->last_visit_day > date("Y-m-d")){
			$this->addError($attribute, 'Incorrect date');
		}
    }
    
    public function searchClients()
    {
        if($this->last_visit_day != null){
            return $searchedClients = ClientsForSending::find()
                ->select('phone_number')
                ->where(['<=', 'last_visit_day', $this->last_visit_day])
                ->all();
        } else {
            Yii::$app->session->setFlash('searchingClients', "Enter the date");
        }
    }
    
    public function sendSMS($phoneNumbers, $messageText)
    {
        $openKey = 'cd777d3f771b3cfb632d94767950348d';
        $privateKey = '5346071f3207ae1ad36eabcbd5a9b191';
    //  Control Sum for creating addressbook
         $params ['version'] ="3.0";
         $params ['action'] = "sendsmsgroup";
         $params ['key'] = $openKey; //you open key
         $params ['sender'] = 'Felix';
         $params ['text'] = $messageText;
         $params ['phones'] =  $phoneNumbers;
         $params ['datetime'] = '';
         $params ['sms_lifetime'] = 0;
         ksort ($params);
         $sum='';
         foreach ($params as $k=>$v){
             $sum.=$v;
         }   
         $sum .= $privateKey; //your private key
         $control_sum =  md5($sum);
 
    //  Send SMS
         $myCurl = curl_init();
         curl_setopt_array($myCurl, array(
             CURLOPT_URL => 'http://api.myatompark.com/sms/3.0/sendsmsgroup?',
             CURLOPT_RETURNTRANSFER => true,
             CURLOPT_POST => true,
             CURLOPT_POSTFIELDS => http_build_query(array(
                 'key' => $openKey,
                 'sum' => $control_sum,
                 'sender' => 'Felix',
                 'text' => $messageText,   
                 'phones' => $phoneNumbers,
                 'datetime' => '',
                 'sms_lifetime' => 0,
             ))
         ));
         $response = curl_exec($myCurl);
         curl_close($myCurl);
    }
}
?>