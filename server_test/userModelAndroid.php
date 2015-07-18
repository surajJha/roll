<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 28/1/15
 * Time: 12:29 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once 'databaseConnection.php';
require_once 'userUtil.php';
class UserModelAndroid
{
    protected $userUtil = '';

    public function __construct()
    {
        $this->userUtil = new UserUtil();
    }

    /**
     * This function takes category_name as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */



    public function getEventsByCategory($category_name, $index, $which_day){
        $db = $this->userUtil->getDatabaseObject();
        if($category_name!=''){
            if($which_day == 'today'){

                    $current_date = date("Y-m-d");
                    $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name_android, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.category_name = '{$category_name}'and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";

            }
            elseif($which_day == 'tomorrow'){
                    $current_date = date("Y-m-d", time()+86400);
                    $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name_android, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.category_name = '{$category_name}'and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";

            }
            elseif($which_day == 'later'){
                    $from_date = date('Y-m-d', strtotime("+2 days"));
                    $to_date = date('Y-m-d', strtotime("+7 days"));
                    $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name_android, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' and ed.category_name = '{$category_name}'and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";

            }
        }
        else{
            $result['status'] = 'failure';
            $result['message'] = 'Category field is empty. Please pass the category';
        }

        $temp = $db->query($query);
        $result = array();
        $result = $this->userUtil->formatEventDetail($temp);
        return $result;
    }

    public function getAllEvents($current_date){
        $db = $this->userUtil->getDatabaseObject();
        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date >= '{$current_date}' and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";
        $temp = $db->query($query);
        $result =array();
        $result = $this->userUtil->formatEventDetail($temp);
        return $result;
    }

}