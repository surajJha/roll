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

class UserController
{
    protected $func = '';
    protected $response_code = array(
        '10' => 'Success',
        '11' => 'Missing Arguments',
        '12' => 'Failed to connect to the database',
        '13' => 'Database query failed'
    );


    public function __construct()
    {
        $func = $_GET['func'];
        $this->$func();

    }

    /**
     * This function takes as input the category_name
     * and returns an array of data corresponding to
     * all the events of particular category
     */

    public function getEventByCategory(){
        $category = $this->custom_filter_input($_GET['category']);
        $index = $this->custom_filter_input($_GET['index']);
        $which_day = $this->custom_filter_input($_GET['which_day']);

        $model = new UserModel();
        $result = $model->getEventsByCategory($category, $index, $which_day);
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
        $current_date = date("Y-m-d");
        $model = new UserModel();
        $result = $model->getTodaysEvents($current_date);
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

        $current_date = date("Y-m-d", time()+86400);
        $model = new UserModel();
        $result = $model->getTomorrowsEvents($current_date);
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
        $from_date = date('Y-m-d', strtotime("+2 days"));
        $to_date = date('Y-m-d', strtotime("+7 days"));
        $model = new UserModel();
        $result = $model->getLatersEvents($from_date, $to_date);
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
        $city = $this->custom_filter_input($_GET['city']);
        $q = $this->custom_filter_input($_GET['q']);
        $model = new UserModel();
        $result = $model->getSearchResults($city, $q);

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
        $searchParam = $this->custom_filter_input($_GET['searchParam']);
        $tablename = $this->custom_filter_input($_GET['tablename']);
        $index = $this->custom_filter_input($_GET['index']);
        $which_day = $this->custom_filter_input($_GET['which_day']);

        $model = new UserModel();
        $result = $model->getEventBySearch($searchParam, $tablename, $index, $which_day);

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

    /*This function takes event_detail_id as and input
    * and returns the detail of a particular event
    */

    public function getEventDetail(){
        $event_detail_id = $this->custom_filter_input($_GET['event_detail_id']);
        $model = new UserModel();
        $result = $model->getEventDetail($event_detail_id);

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

    function custom_filter_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}

$model1 = new UserController();