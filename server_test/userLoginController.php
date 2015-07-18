<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 18/7/15
 * Time: 4:27 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
require_once 'ExecutionTimeLogger.php';
require_once 'userLoginModel.php';
require_once 'userUtil.php';

class UserLoginController{
    protected $func = '';
    protected $executionTimeLogger = '';
    protected $userLoginModel = '';
    protected $userUtil = '';
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
        $this->userLoginModel = new UserLoginModel();
        $this->userUtil = new UserUtil();
        $this->$func();
    }

    public function socialUserLogin(){
        $start = microtime(true);
        $user_id = (isset($_POST['user_id']) && $_POST['user_id']!=null )?$this->userUtil->custom_filter_input($_POST['user_id']):'';
        $username = (isset($_POST['user_name']) && $_POST['user_name']!=null )?$this->userUtil->custom_filter_input($_POST['user_name']):'';
        $emailId = (isset($_POST['user_email_id']) && $_POST['user_email_id']!=null )?$this->userUtil->custom_filter_input($_POST['user_email_id']):'';
        $dob = (isset($_POST['dob']) && $_POST['dob']!=null )?$this->userUtil->custom_filter_input($_POST['dob']):'';
        $city = (isset($_POST['city']) && $_POST['city']!=null )?$this->userUtil->custom_filter_input($_POST['city']):'';
        $socialLoginId = (isset($_POST['social_login_id']) && $_POST['social_login_id']!=null )?$this->userUtil->custom_filter_input($_POST['social_login_id']):'';
        $socialLoginService = (isset($_POST['social_login_service']) && $_POST['social_login_service']!=null )?$this->userUtil->custom_filter_input($_POST['social_login_service']):'';
        $result = $this->userLoginModel->socialUserLogin($user_id, $username, $emailId, $dob, $city, $socialLoginId, $socialLoginService);
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
}

$model1 = new UserLoginController();