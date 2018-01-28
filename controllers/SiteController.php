<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use app\models\Visitors;
use app\models\VisitorsBonus;
use app\models\Clients;
use app\models\Employees;
use app\models\User;
use app\models\Cities;
use app\models\Revenues;
use app\models\ClientsForSending;

class SiteController extends Controller
{
    /**
     * @inheritdoc
     */

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'visitors', 'clients', 'manage'],
                'rules' => [
                    [
                        'actions' => ['logout', 'visitors', 'clients', 'manage'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */

    public function actionLogin()
    {        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(array('visitors'));
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    
    /**
     * Displays about page.
     *
     * @return string
     */
    
    public function actionVisitors()
    {    
        $visitors = new Visitors();
        $visitorsBonus = new VisitorsBonus();
        $clients = new Clients();
        $employees = new Employees();
        $employeesBonus = new Employees();
        $revenues = new Revenues();
        $city_id = Yii::$app->user->identity->city_id;
        $user_id = Yii::$app->user->identity->id;
        $employee_bonus = Yii::$app->user->identity->employee_bonus;

        if($visitors->load(Yii::$app->request->post())  && $visitors->validate()){
        //  Add clients and their bonus
            if(isset($_POST['Registration'])){
                $visitors->addVisitor($city_id);   
            } 
            $this->redirect(array('visitors'));
        }   
        if($visitorsBonus->load(Yii::$app->request->post())  && $visitorsBonus->validate()){ 
        //  Delete bonus for clients
            if(isset($_POST['deleteBonus'])){
                $visitorBonus = Visitors::find()
                    ->where(['username' => $visitorsBonus->username, 'phone_number'=> $visitorsBonus->phone_number])->andwhere(['<>', 'bonus', 0])
                    ->one();
                $clientBonus = Clients::findOne(['username' => $visitorsBonus->username, 'phone_number'=> $visitorsBonus->phone_number]);
                if(isset($visitorBonus) && isset($clientBonus)){
                    $visitorsBonus->deleteBonus($visitorBonus, $clientBonus); 
                    $this->redirect(array('visitors'));
                } else {
			        Yii::$app->session->setFlash('clientBonusNotFound', "Person not found or his bonus = 0");
                }
            }
        }
        // Employees work
        if($employees->load(Yii::$app->request->post())  && $employees->validate()){
            $currentEmployee = Employees::findOne(['username' => $employees->username, 'phone_number'=> $employees->phone_number]);
            if(isset($currentEmployee)){
            //  Start work
                if(isset($_POST['StartWork']) && $currentEmployee->start_work == 0 && $currentEmployee->end_work == 0){ 
                    $currentEmployee->start_work = $currentEmployee->addCurrentTime();
                    $currentEmployee->save();
                    $this->redirect(array('visitors'));
                } elseif(isset($_POST['StartWork']) && $currentEmployee->start_work != 0 && $currentEmployee->end_work == 0) {
                    Yii::$app->session->setFlash('employeeWorking', "Person is working now");
                } elseif(isset($_POST['StartWork']) && $currentEmployee->start_work != 0 && $currentEmployee->end_work != 0){
                    Yii::$app->session->setFlash('employeeWorked', "Person worked today");
                }
            //  End work
                if(isset($_POST['EndWork']) && $currentEmployee->start_work != 0 && $currentEmployee->end_work == 0){
                    $currentEmployee->end_work = $currentEmployee->addCurrentTime();
                    $currentEmployee->save();
                    $this->redirect(array('visitors'));
                } elseif(isset($_POST['StartWork']) && $currentEmployee->start_work == 0) {
                    Yii::$app->session->setFlash('employeeWorking', "Person is not working now");
                } elseif(isset($_POST['EndWork']) && $currentEmployee->start_work != 0 && $currentEmployee->end_work != 0) {
                    Yii::$app->session->setFlash('employeeWorked', "Person worked today");
                }
            } else {
                Yii::$app->session->setFlash('employeeNotFound', "Person not found");
            }
        }
        $AllVisitors = Visitors::findAll(['city_id' => $city_id]);    
        $AllEmployeesWorked = Employees::find()
            ->where(['city_id' => $city_id])
            ->andwhere(['<>', 'start_work', 0])
            ->all();
        $nowWorkingEmployees = Employees::find()
            ->where(['city_id'=>$city_id, 'end_work'=> NULL])
            ->andwhere(['<>', 'start_work', 0])->all();
        if (isset($_POST['AddEmployeesBonus']) && $nowWorkingEmployees == NULL){
        //  Add bonus for employees    
            $employees->AddEmployeesBonus($AllEmployeesWorked, $AllVisitors, $city_id, $employee_bonus);
        //  Add Revenue for Area
            $revenues->AddRevenue($AllVisitors, $city_id, $user_id);
        //  Clear visitors and add employees bonus    
            $visitors->clearVisitors();
            $this->redirect(array('visitors'));
        } elseif($nowWorkingEmployees != NULL) {
            Yii::$app->session->setFlash('employeeWorkNow', "Employees are working now");
        }
      
        return $this->render('visitors', compact('visitors',
                                                'visitorsBonus', 
                                                'clients', 
                                                'AllVisitors', 
                                                'AllEmployeesWorked', 
                                                'errors', 
                                                'employeesBonus', 
                                                'employees', 
                                                'nowWorkingEmployees'));
    }

    public function actionClients()
    {
        $clients = new Clients();
        $city_id = Yii::$app->user->identity->city_id; 

        if($clients->load(Yii::$app->request->post()) && $clients->validate()){
        //  Add Clients
            $currentClient = Clients::findOne(['username' => $clients->username, 'phone_number'=> $clients->phone_number]);
            if(isset($currentClient)){
                Yii::$app->session->setFlash('clientRegistered', "This customer has been registered");
            } else {
                $clients->addClients($city_id);              
                $this->redirect(array('clients'));
            }
        } 
        return $this->render('clients', compact('clients'));
    }
    
    public function actionManage()
    {
        // Is Admin
        if(Yii::$app->user->identity->is_admin == 0){
            $this->redirect(array('visitors'));
        }
        
        $users = new User();
        $cities = new Cities();
        $selectedUserForRevenue = new Revenues();
        $selectedCityForEmployees = new Cities();
        $employees = new Employees();
        $city_id = Yii::$app->user->identity->city_id;
        $clientsForSending = new ClientsForSending();

        if($users->load(Yii::$app->request->post()) && $users->validate() && $cities->load(Yii::$app->request->post()) && $cities->validate()){
            $searchUser = User::findOne(['username' => $users->username, 'phone_number'=> $users->phone_number]);
            if(!isset($searchUser)){
            //  Add Cities
                $haveCity = Cities::findOne(['city' => $cities->city]);
                if(isset($haveCity)){
                    $currentCity =  $haveCity;
                } else {
                    $cities->save();
                    $currentCity = Cities::findOne(['city' => $cities->city]); 
                }
            //  Add Users
                $users->addUsers($currentCity);  
            } else {
                $users->addBonusKoef($searchUser);
            }    
            $this->redirect(array('manage'));
        }
        if($employees->load(Yii::$app->request->post())  && $employees->validate()){
        //  Add Employee
            if(isset($_POST['AddEmployees'])){
                $employees->city_id = $city_id;
                $employees->save();   
            }  
        //  Delete Bonus
            if(isset($_POST['DeleteBonus'])){
                $currentEmployee = Employees::find()
                    ->where(['username' => $employees->username, 'phone_number'=> $employees->phone_number])
                    ->andwhere(['<>', 'bonus', 0])
                    ->one();
                if(isset($currentEmployee)){
                    $currentEmployee->deleteBonus();
                    $this->redirect(array('manage'));   
                } else {
                    Yii::$app->session->setFlash('employeeBonusNotFound', "Person not found or his bonus = 0");
                }
            }
        //  Delete Employee
            if(isset($_POST['DeleteEmployee'])){
                $currentEmployee = Employees::findOne(['username' => $employees->username, 'phone_number'=> $employees->phone_number]);
                if(isset($currentEmployee)){
                    $currentEmployee->delete();
                    $this->redirect(array('manage'));   
                } else {
                    Yii::$app->session->setFlash('employeeBonusNotFound', "Person not found");
                }
            }
        }
        $AllRevenues = $selectedUserForRevenue->load(Yii::$app->request->post()) 
        ? $selectedUserForRevenue->selectRevenueByUser()
        : null;
        $AllEmployeesManage = $selectedCityForEmployees->load(Yii::$app->request->post())
        ? $selectedCityForEmployees->selectEmployeeByCity()
        : Employees::find()->with(['cities'])->all();
        $AllCities = Cities::find()->all();
        $AllUsers = User::findAll(['is_admin' => 0]);

        //SMS 
        if($clientsForSending->load(Yii::$app->request->post())  && $clientsForSending->validate()){
            if(isset($_POST['Search'])){
            //  Search clients
                $searchedClients = $clientsForSending->searchClients();
                $messageText = $clientsForSending->messageText;
                if(!isset($searchedClients)){
                    Yii::$app->session->setFlash('searchingClients', "Clients not found");
                }
            // JSON view
                $i=0;
                foreach($searchedClients as $searchedClient){
                        $phoneNumbers[$i][0] = intval($searchedClient->phone_number);
                        $i++;
                }
                $phoneNumbers = json_encode($phoneNumbers);
            //Send
                $clientsForSending->sendSMS($phoneNumbers, $messageText);
            }  
            $this->redirect(array('manage')); 
        }

        return $this->render('manage', compact('users', 
                                            'cities', 
                                            'AllCities', 
                                            'employees', 
                                            'AllEmployeesManage', 
                                            'AllUsers', 
                                            'selectedCityForEmployees', 
                                            'selectedUserForRevenue',
                                            'AllRevenues',
                                            'clientsForSending'
                                        ));
    }
}
