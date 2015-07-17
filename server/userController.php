<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 28/1/15
 * Time: 12:29 PM
 */

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once 'userModel.php';
require_once 'ExecutionTimeLogger.php';

class UserController
{
    protected $func = '';
    protected $executionTimeLogger = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );


    public function __construct()
    {
        $func = $_GET['func'];
        $this->executionTimeLogger = new ExecutionTimeLogger();
        $this->$func();

    }

    /**
     * This function takes as input the category_name
     * and returns an array of data corresponding to
     * all the events of particular category
     */

    public function getEventByCategory(){
        $start = microtime(true);
        $category = $this->custom_filter_input($_GET['category']);
        $index = $this->custom_filter_input($_GET['index']);
        $which_day = $this->custom_filter_input($_GET['which_day']);

        $model = new UserModel();
        $result = $model->getEventsByCategory($category, $index, $which_day);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventByCategory", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    /**
     * This function takes as input the category_name
     * and returns an array of data corresponding to
     * all the events of particular category
     */

    public function getEventsByCategoryAndroid(){
        $start = microtime(true);
        $category = $this->custom_filter_input($_GET['category']);
        if($category == 'Food   Drinks')
            $category = 'Food + Drinks';
        $index = $this->custom_filter_input($_GET['index']);
        $which_day = $this->custom_filter_input($_GET['which_day']);

        $model = new UserModel();
        $result = $model->getEventsByCategoryAndroid($category, $which_day);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventsByCategoryAndroid", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    /**
     * This function calculates today's date
     * and returns an array of data corresponding to
     * all the events happening today
     */

    public function getTodaysEvents(){
        $start = microtime(true);
        $current_date = date("Y-m-d");
        $model = new UserModel();
        $result = $model->getTodaysEvents($current_date);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getTodaysEvents", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    /**
     * This function calculates tomorrow's date
     * and returns an array of data corresponding to
     * all the events happening today
     */

    public function getTomorrowsEvents(){
        //1 Day = 24*60*60 = 86400
        $start = microtime(true);
        $current_date = date("Y-m-d", time()+86400);
        $model = new UserModel();
        $result = $model->getTomorrowsEvents($current_date);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getTomorrowsEvents", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    /**
     * This function calculates 7 days later date
     * and 2 days later date and sends it as parameter
     * and returns an array of data corresponding to
     * all the events happening today
     */

    public function getLatersEvents(){
        $start = microtime(true);
        $from_date = date('Y-m-d', strtotime("+2 days"));
        $to_date = date('Y-m-d', strtotime("+7 days"));
        $model = new UserModel();
        $result = $model->getLatersEvents($from_date, $to_date);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getLatersEvents", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    public function getAllEvents(){
        $start = microtime(true);
        $current_date = date("Y-m-d");
        $model = new UserModel();
        $result = $model->getAllEvents($current_date);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getAllEvents", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    public function getSearchResults()
    {
        $start = microtime(true);
        $city = $this->custom_filter_input($_GET['city']);
        $q = $this->custom_filter_input($_GET['q']);
        $model = new UserModel();
        $result = $model->getSearchResults($city, $q);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getSearchResults", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else{
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    public function getEventBySearch(){
        $start = microtime(true);
        $searchParam = $this->custom_filter_input($_GET['searchParam']);
        $tablename = $this->custom_filter_input($_GET['tablename']);
        $index = $this->custom_filter_input($_GET['index']);
        $which_day = $this->custom_filter_input($_GET['which_day']);

        $model = new UserModel();
        $result = $model->getEventBySearch($searchParam, $tablename, $index, $which_day);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventBySearch", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    public function getEventDetail(){
        $start = microtime(true);
        $event_detail_id = $this->custom_filter_input($_GET['event_detail_id']);
        $model = new UserModel();
        $result = $model->getEventDetail($event_detail_id);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventDetail", $start, $end);
        if($result['status'] == 'success')
        {
            echo json_encode($result['data']);
        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }

    public function socialUserLogin(){
        $start = microtime(true);
        $user_id = (isset($_POST['user_id']) && $_POST['user_id']!=null )?$this->custom_filter_input($_POST['user_id']):'';
        $username = (isset($_POST['user_name']) && $_POST['user_name']!=null )?$this->custom_filter_input($_POST['user_name']):'';
        $emailId = (isset($_POST['user_email_id']) && $_POST['user_email_id']!=null )?$this->custom_filter_input($_POST['user_email_id']):'';
        $dob = (isset($_POST['dob']) && $_POST['dob']!=null )?$this->custom_filter_input($_POST['dob']):'';
        $city = (isset($_POST['city']) && $_POST['city']!=null )?$this->custom_filter_input($_POST['city']):'';
        $socialLoginId = (isset($_POST['social_login_id']) && $_POST['social_login_id']!=null )?$this->custom_filter_input($_POST['social_login_id']):'';
        $socialLoginService = (isset($_POST['social_login_service']) && $_POST['social_login_service']!=null )?$this->custom_filter_input($_POST['social_login_service']):'';

        $model = new UserModel();
        $result = $model->socialUserLogin($user_id, $username, $emailId, $dob, $city, $socialLoginId, $socialLoginService);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("socialUserLogin", $start, $end);
        if($result['status'] == 'success')
        {

            if($result['data'] == 'Data Inserted Successfully'){
                $result['data'] = array();
                echo json_encode($result['data']);
            }
            else{
                echo json_encode($result['data']);
            }

        }
        else
        {
            $result['data'] = array();
            echo json_encode($result['data']);
        }
    }


    function custom_filter_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}

$model1 = new UserController();