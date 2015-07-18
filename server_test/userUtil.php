<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 18/7/15
 * Time: 2:23 PM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'databaseConnection.php';
class UserUtil{

    public function __construct(){}

    /**
     * @return mysqli
     * function creates a new DatabaseConnection object
     * and calls the getConntection() and returns
     * a mysqli object
     */
    public function getDatabaseObject()
    {
        $db = new DatabaseConnection();
        return $db->getConnection();
    }

    public function custom_filter_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function formatResults($result){
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
    
    public function formatEvent($row){
        $rows = array();
        $rows['category_name'] = $row['category_name'];
        $rows['category_color'] = $row['category_color'];
        $rows['event_area'] = $row['area_name'];
        $rows['event_city'] = $row['city_name'];
        $rows['event_cost'] = intval($row['event_cost']);
        $rows['event_detail_id'] = intval($row['event_detail_id']);
        $rows['event_location'] = $row['event_location'];
        $rows['event_name'] = $row['event_name'];
        $rows['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
        $rows['venue_name'] = $row['venue_name'];
        $rows['event_latitude'] = floatval($row['event_latitude']);
        $rows['event_longitude'] = floatval($row['event_longitude']);
        $rows['event_hashtags'] = explode(' ',$row['event_hashtags']);

        return $rows;
    }
    
    public function formatEventSchedule($schedule){
        $rows = array();
        $temp_date_array = explode(',',$schedule);
        $y = array();
        foreach ($temp_date_array as $x)
        {
            $y = explode('=',$x);
            $z = array();
            $z['date'] = $y[0];
            $z['start_time'] = $y[1];
            $z['end_time'] = $y[2];

            $y = explode('-',$z['date']);
            $z['day'] = $y[2];
            $z['month'] = $y[1];
            $z['year'] = $y[0];

            $y = explode(':',$z['start_time']);
            $z['start_time_hour'] = $y[0];
            $z['start_time_min'] = $y[1];

            $y = explode(':',$z['end_time']);
            $z['end_time_hour'] = $y[0];
            $z['end_time_min'] = $y[1];

            array_push($rows , $z);
            }
        return $rows;
    }

    public function formatEventImage($image){
        $rows = array();
        $temp_image_array = explode(',',$image);
        $y = array();
        foreach ($temp_image_array as $x)
        {
            $y = explode('=',$x);
            $z = array();
            $z['image_path'] = $y[0];
            $z['primary'] = $y[1];
            $z['primary_bool'] = $z['primary'] == '1'? true : false;
            array_push($rows , $z);
        }

        return $rows;
    }

    public function formatEventDetail($temp){
        if($temp->num_rows>0)
        {
            $i = 0;
            while($row = $temp->fetch_assoc())
            {
                $rows[$i] = $this->formatEvent($row);

                if($row['schedule']) {
                    $rows[$i]['datetime'] = array();
                    $rows[$i]['datetime'] = $this->formatEventSchedule($row['schedule']);
                }
                else{
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }

                if($row['image'])
                {
                    $rows[$i]['image'] = array();
                    $rows[$i]['image'] = $this->formatEventImage($row['image']);
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Image URL\'s not fetched Properly';
                    return $result;
                }
                $i++;
            }

            $result['status'] = 'success';
            $result['message'] = 'Event Details successfully fetched';
            $result['data'] = $rows;
            return $result;
        }
        else {
            $result['status'] = "failure";
            $result['message'] = 'All the event details were not fetched properly. Please check database errors or database LOG file for more information';
            $result['data'] = '';
            return $result;

        }
    }
}