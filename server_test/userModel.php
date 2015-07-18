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
class UserModel
{
    protected $event_organiser_id;
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
                $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.category_name = '{$category_name}'and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count  LIMIT {$index},3";
            }
            elseif($which_day == 'tomorrow'){
                $current_date = date("Y-m-d", time()+86400);
                $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.category_name = '{$category_name}'and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count  LIMIT {$index},3";
            }
            elseif($which_day == 'later'){
                $from_date = date('Y-m-d', strtotime("+2 days"));
                $to_date = date('Y-m-d', strtotime("+7 days"));
                $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a, category as c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' and ed.category_name = '{$category_name}'and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count  LIMIT {$index},3";
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

    /**
     * This function takes event_detail_id as input and based on this it fires a SELECT query to
     * fetch data of all the events belonging to the particular Organiser.
     * The date and time is stored as arrays in an outer array. Same is done for storing the
     * Image URL's.Thus the entire result is sent back as a multidimensional array.
     */

    public function getEventDetail($event_detail_id)
    {
        $db = $this->userUtil->getDatabaseObject();
        $current_date = date("Y-m-d");
        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, ed.event_latitude, ed.event_longitude, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.viewer_count, ed.priority_count, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and ed.event_detail_id = '{$event_detail_id}' and es.event_date >= '{$current_date}'";

        $temp = $db->query($query);
        $result =array();
        $result = $this->userUtil->formatEventDetail($temp);
        return $result;
    }

    /**
     * This function will send the results
     * based on search param
     */

    public function getSearchResults($city, $q)
    {
        $db = $this->userUtil->getDatabaseObject();
        $current_date = date("Y-m-d");
        $query = "select area_name, 'Area' as type, '' as event_detail_id, '' as event_name FROM area WHERE area_name LIKE '{$q}%' AND city_name = '{$city}' UNION ALL  select DISTINCT e.event_name, 'Event' as type, e.event_detail_id, e.event_name FROM event_detail e, area a, event_schedule es WHERE e.event_area_id = a.area_id and a.city_name = '{$city}' and e.event_name LIKE '{$q}%' and e.event_detail_id = es.event_detail_id and es.event_date >= '{$current_date}' UNION ALL  select DISTINCT e.venue_name, 'Venue' as type, '', '' FROM event_detail e, area a, event_schedule es WHERE e.event_area_id = a.area_id and a.city_name = '{$city}' and e.venue_name LIKE '{$q}%' and e.event_detail_id = es.event_detail_id and es.event_date >= '{$current_date}'";


        $temp = $db->query($query);

        $result =array();
        if($temp->num_rows>0) {

            $i = 0;
            while ($row = $temp->fetch_assoc()){

                $rows[$i]['area_name'] = htmlspecialchars_decode(stripslashes($row['area_name']));
                $rows[$i]['type'] = $row['type'];
                $rows[$i]['event_detail_id'] = intval($row['event_detail_id']);
                $rows[$i]['event_name'] = $row['event_name'];
                $i++;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
        }
        else{
            $result['status'] = 'failure';
            $result['data'] = 'No results found';
        }
        return $result;
    }

    public function getEventBySearch($searchParam,$tablename, $index){
        $db = $this->userUtil->getDatabaseObject();

        $current_date = date("Y-m-d");
        if($tablename == 'Venue'){
            $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, ed.event_latitude, ed.event_longitude, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a, category c  where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date >= '{$current_date}' and ed.venue_name='{$searchParam}' and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
        }
        elseif($tablename == 'Area'){
            $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, ed.event_latitude, ed.event_longitude, a.area_name, a.city_name, c.category_color, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a, category c where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date >= '{$current_date}' and a.area_name='{$searchParam}' and c.category_name = ed.category_name group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
        }

        $temp = $db->query($query);
        $result =array();
        $result = $this->userUtil->formatEventDetail($temp);
        return $result;

    }

}