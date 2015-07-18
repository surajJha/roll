<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 28/1/15
 * Time: 12:29 PM
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
include_once 'userModelAndroid.php';
require_once 'ExecutionTimeLogger.php';
require_once 'userUtil.php';

class UserControllerAndroid
{
    protected $func = '';
    protected $executionTimeLogger = '';
    protected $userUtil = '';
    protected $userModelAndroid = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );


    public function __construct()
    {
        $this->executionTimeLogger = new ExecutionTimeLogger();
        $this->userUtil = new UserUtil();
        $this->userModelAndroid = new UserModelAndroid();

        $func = $_GET['func'];
        $this->$func();
    }

    /**
     * This function takes as input the category_name
     * and returns an array of data corresponding to
     * all the events of particular category
     */

    public function getEventsByCategory(){
        $start = microtime(true);
        $category = $this->userUtil->custom_filter_input($_GET['category']);
        if($category == 'Food   Drinks')
            $category = 'Food + Drinks';
        $index = $this->userUtil->custom_filter_input($_GET['index']);
        $which_day = $this->userUtil->custom_filter_input($_GET['which_day']);

        $result = $this->userModelAndroid->getEventsByCategory($category, $index, $which_day);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventsByCategoryAndroid", $start, $end);

        $this->userUtil->formatResults($result);
    }

    public function getAllEvents(){
        $start = microtime(true);
        $current_date = date("Y-m-d");
        $result = $this->userModelAndroid->getAllEvents($current_date);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getAllEvents", $start, $end);
        $this->userUtil->formatResults($result);
    }

}

$model1 = new UserControllerAndroid();