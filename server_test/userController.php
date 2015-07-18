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
include_once 'userModel.php';
require_once 'ExecutionTimeLogger.php';
require_once 'userUtil.php';

class UserController
{
    protected $func = '';
    protected $executionTimeLogger = '';
    protected $userUtil = '';
    protected $userModel = '';
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
        $this->userModel = new UserModel();

        $func = $_GET['func'];
        $this->$func();
    }

    /**
     * This function takes as input the category_name
     * and returns an array of data corresponding to
     * all the events of particular category
     */

    public function getEventByCategory(){
        $start = microtime(true);
        $category = $this->userUtil->custom_filter_input($_GET['category']);
        $index = $this->userUtil->custom_filter_input($_GET['index']);
        $which_day = $this->userUtil->custom_filter_input($_GET['which_day']);

        $result = $this->userModel->getEventsByCategory($category, $index, $which_day);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventByCategory", $start, $end);

        $this->userUtil->formatResults($result);
    }

    /**
     * This function sends the detail of
     * event based on event id
     */

    public function getEventDetail(){
        $start = microtime(true);
        $event_detail_id = $this->userUtil->custom_filter_input($_GET['event_detail_id']);
        $result = $this->userModel->getEventDetail($event_detail_id);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventDetail", $start, $end);
        $this->userUtil->formatResults($result);
    }

    /**
     * This function will send the results
     * based on search param
     */
    public function getSearchResults()
    {
        $start = microtime(true);
        $city = $this->userUtil->custom_filter_input($_GET['city']);
        $q = $this->userUtil->custom_filter_input($_GET['q']);
        $result = $this->userModel->getSearchResults($city, $q);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getSearchResults", $start, $end);
        $this->userUtil->formatResults($result);
    }

    public function getEventBySearch(){
        $start = microtime(true);
        $searchParam = $this->userUtil->custom_filter_input($_GET['searchParam']);
        $tablename = $this->userUtil->custom_filter_input($_GET['tablename']);
        $index = $this->userUtil->custom_filter_input($_GET['index']);
        $which_day = $this->userUtil->custom_filter_input($_GET['which_day']);

        $result = $this->userModel->getEventBySearch($searchParam, $tablename, $index, $which_day);
        $end = microtime(true);
        $this->executionTimeLogger->logExecutionTime("getEventBySearch", $start, $end);
        $this->userUtil->formatResults($result);
    }


}

$model1 = new UserController();