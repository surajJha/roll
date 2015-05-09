<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 28/1/15
 * Time: 12:29 PM
 */
//ini_set('display_errors', '1');
include_once 'databaseConnection.php';
class UserModel
{
    protected $event_organiser_id;

    public function __construct()
    {

    }

    /**
     * @return mysqli
     * function creates a new DatabaseConnection object
     * and calls the getConntection() and returns
     * a mysqli object
     */
    protected function getDatabaseObject()
    {
        $db = new DatabaseConnection();
        return $db->getConnection();
    }

    /**
     * This function takes category_name as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */



    public function getEventsByCategory($category_name, $index, $which_day){
        $db = $this->getDatabaseObject();
        if($which_day == 'today'){
            if($category_name!=''){
                $current_date = date("Y-m-d");
                $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.category_name = '{$category_name}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count  LIMIT {$index},3";

            }
            else{
                $result['status'] = 'failure';
                $result['message'] = 'Category field is empty. Please pass the category';
            }
        }
        elseif($which_day == 'tomorrow'){
            if($category_name!=''){
                $current_date = date("Y-m-d", time()+86400);
                $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.category_name = '{$category_name}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count  LIMIT {$index},3";
            }
            else{
                $result['status'] = 'failure';
                $result['message'] = 'Category field is empty. Please pass the category';
            }
        }
        elseif($which_day == 'later'){
            if($category_name!=''){
                $from_date = date('Y-m-d', strtotime("+3 days"));
                $to_date = date('Y-m-d', strtotime("+7 days"));
                $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' and ed.category_name = '{$category_name}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count  LIMIT {$index},3";
            }
            else{
                $result['status'] = 'failure';
                $result['message'] = 'Category field is empty. Please pass the category';
            }
        }

        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0)
        {
            $i = 0;
            while($row = $temp->fetch_assoc())
            {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['area_name'];
                $rows[$i]['event_city'] = $row['city_name'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = array();
                $rows[$i]['event_hashtags'] = explode(' ',$row['event_hashtags']);
                if($row['schedule'])
                {
                    $temp_date_array = explode(',',$row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];

                        $y = explode('-',$z['date']);
                        $z['day'] = $y[0];
                        $z['month'] = $y[1];
                        $z['year'] = $y[0];

                        $y = explode(':',$z['start_time']);
                        $z['start_time_hour'] = $y[0];
                        $z['start_time_min'] = $y[1];

                        $y = explode(':',$z['end_time']);
                        $z['end_time_hour'] = $y[0];
                        $z['end_time_min'] = $y[1];

                        array_push($rows[$i]['datetime'] , $z);
                    }
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }
                if($row['image'])
                {
                    $temp_image_array = explode(',',$row['image']);
                    $y = array();
                    foreach ($temp_image_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['image_path'] = $y[0];
                        $z['primary'] = $y[1];
                        array_push($rows[$i]['image'] , $z);
                    }
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

    /**
     * This function takes cuurent_date as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */

    public function getTodaysEvents($current_date)
    {
        $db = $this->getDatabaseObject();

        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";

        $temp = $db->query($query);
        $result = array();
        if ($temp->num_rows > 0) {
            $i = 0;
            while ($row = $temp->fetch_assoc()) {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['area_name'];
                $rows[$i]['event_city'] = $row['city_name'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = array();
                $rows[$i]['event_hashtags'] = explode(' ', $row['event_hashtags']);
                if ($row['schedule']) {
                    $temp_date_array = explode(',', $row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x) {
                        $y = explode('=', $x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];

                        $y = explode('-',$z['date']);
                        $z['day'] = $y[0];
                        $z['month'] = $y[1];
                        $z['year'] = $y[0];

                        $y = explode(':',$z['start_time']);
                        $z['start_time_hour'] = $y[0];
                        $z['start_time_min'] = $y[1];

                        $y = explode(':',$z['end_time']);
                        $z['end_time_hour'] = $y[0];
                        $z['end_time_min'] = $y[1];

                        array_push($rows[$i]['datetime'], $z);
                    }
                } else {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }

                if($row['image'])
                {
                    $temp_image_array = explode(',',$row['image']);
                    $y = array();
                    foreach ($temp_image_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['image_path'] = $y[0];
                        $z['primary'] = $y[1];
                        array_push($rows[$i]['image'] , $z);
                    }
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
        } else {
            $result['status'] = "failure";
            $result['message'] = 'All the event details were not fetched properly. Please check database errors or database LOG file for more information';
            $result['data'] = '';
            return $result;

        }

    }

        /**
         * This function takes current_date (which is tomorrow's date) as input and based on this it fires a SELECT query to
         * fetch data of all the events under particular category.
         * The date and time is stored as arrays in an outer array.
         * Thus the entire result is sent back as a multidimensional array.
         */

        public function getTomorrowsEvents($current_date){
            $db = $this->getDatabaseObject();
            $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date = '{$current_date}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";
            $temp = $db->query($query);
            $result =array();
            if($temp->num_rows>0)
            {
                $i = 0;
                while($row = $temp->fetch_assoc())
                {
                    $rows[$i]['category_name'] = $row['category_name'];
                    $rows[$i]['event_area'] = $row['area_name'];
                    $rows[$i]['event_city'] = $row['city_name'];
                    $rows[$i]['event_cost'] = $row['event_cost'];
                    $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                    $rows[$i]['event_location'] = $row['event_location'];
                    $rows[$i]['event_name'] = $row['event_name'];
                    $rows[$i]['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
                    $rows[$i]['venue_name'] = $row['venue_name'];
                    $rows[$i]['datetime'] = array();
                    $rows[$i]['image'] = array();
                    $rows[$i]['event_hashtags'] = explode(' ',$row['event_hashtags']);
                    if($row['schedule'])
                    {
                        $temp_date_array = explode(',',$row['schedule']);
                        $y = array();
                        foreach ($temp_date_array as $x)
                        {
                            $y = explode('=',$x);
                            $z = array();
                            $z['date'] = $y[0];
                            $z['start_time'] = $y[1];
                            $z['end_time'] = $y[2];

                            $y = explode('-',$z['date']);
                            $z['day'] = $y[0];
                            $z['month'] = $y[1];
                            $z['year'] = $y[0];

                            $y = explode(':',$z['start_time']);
                            $z['start_time_hour'] = $y[0];
                            $z['start_time_min'] = $y[1];

                            $y = explode(':',$z['end_time']);
                            $z['end_time_hour'] = $y[0];
                            $z['end_time_min'] = $y[1];

                            array_push($rows[$i]['datetime'] , $z);
                        }
                    }
                    else
                    {
                        $result['status'] = 'failure';
                        $result['message'] = 'Event Schedule not fetched properly';
                        return $result;
                    }
                    if($row['image'])
                    {
                        $temp_image_array = explode(',',$row['image']);
                        $y = array();
                        foreach ($temp_image_array as $x)
                        {
                            $y = explode('=',$x);
                            $z = array();
                            $z['image_path'] = $y[0];
                            $z['primary'] = $y[1];
                            array_push($rows[$i]['image'] , $z);
                        }
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

    /**
     * This function takes from_date and to_date as input and based on this it fires a SELECT query to
     * fetch data of all the events under particular category.
     * The date and time is stored as arrays in an outer array.
     * Thus the entire result is sent back as a multidimensional array.
     */

    public function getLatersEvents($from_date,$to_date){
        $db = $this->getDatabaseObject();

        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.event_organizer_id, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image, ei.event_image_id)) as image from event_detail ed, event_schedule es, event_image ei, area as a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count";

        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0)
        {
            $i = 0;
            while($row = $temp->fetch_assoc())
            {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['area_name'];
                $rows[$i]['event_city'] = $row['city_name'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = array();
                $rows[$i]['event_hashtags'] = explode(' ',$row['event_hashtags']);
                if($row['schedule'])
                {
                    $temp_date_array = explode(',',$row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];

                        $y = explode('-',$z['date']);
                        $z['day'] = $y[0];
                        $z['month'] = $y[1];
                        $z['year'] = $y[0];

                        $y = explode(':',$z['start_time']);
                        $z['start_time_hour'] = $y[0];
                        $z['start_time_min'] = $y[1];

                        $y = explode(':',$z['end_time']);
                        $z['end_time_hour'] = $y[0];
                        $z['end_time_min'] = $y[1];

                        array_push($rows[$i]['datetime'] , $z);
                    }
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }

                if($row['image'])
                {
                    $temp_image_array = explode(',',$row['image']);
                    $y = array();
                    foreach ($temp_image_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['image_path'] = $y[0];
                        $z['primary'] = $y[1];
                        array_push($rows[$i]['image'] , $z);
                    }
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

    public function getSearchResults($city, $q)
    {
        $current_date = date("Y-m-d");
        $db = $this->getDatabaseObject();
        $query = "select area_name, 'Area' as type, '' as event_detail_id FROM area WHERE area_name LIKE '{$q}%' AND city_name = '{$city}' UNION ALL  select DISTINCT e.event_name, 'Event' as type, e.event_detail_id FROM event_detail e, area a, event_schedule es WHERE e.event_area_id = a.area_id and a.city_name = '{$city}' and e.event_name LIKE '{$q}%' and e.event_detail_id = es.event_detail_id and es.event_date >= '{$current_date}' UNION ALL  select e.venue_name, 'Venue' as type, '' FROM event_detail e, area a, event_schedule es WHERE e.event_area_id = a.area_id and a.city_name = '{$city}' and e.venue_name LIKE '{$q}%' and e.event_detail_id = es.event_detail_id and es.event_date >= '{$current_date}'";

        $temp = $db->query($query);

       // var_dump($temp->num_rows>0);
        $result =array();
        if($temp->num_rows>0) {

            $i = 0;
            while ($row = $temp->fetch_assoc()){

                $rows[$i]['area_name'] = htmlspecialchars_decode(stripslashes($row['area_name']));
                $rows[$i]['type'] = $row['type'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
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

    public function getEventBySearch($searchParam,$tablename, $index, $which_day){
        $db = $this->getDatabaseObject();

        if($which_day == 'today'){
            $current_date = date("Y-m-d");
            if($tablename == 'Venue'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.venue_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
            elseif($tablename == 'Area'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date = '{$current_date}' and a.area_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
            elseif($tablename == 'Event'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.event_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
        }
        elseif($which_day == 'tomorrow'){
            $current_date = date("Y-m-d", time()+86400);
            if($tablename == 'Venue'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.venue_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
            elseif($tablename == 'Area'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date = '{$current_date}' and a.area_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
            elseif($tablename == 'Event'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date = '{$current_date}' and ed.event_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
        }
        elseif($which_day == 'later'){
            $from_date = date('Y-m-d', strtotime("+3 days"));
            $to_date = date('Y-m-d', strtotime("+7 days"));
            if($tablename == 'Venue'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' and ed.venue_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
            elseif($tablename == 'Area'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' and a.area_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
            elseif($tablename == 'Event'){
                $query = "select ed.event_detail_id, ed.venue_name, ed.event_name, ed.event_hashtags, ed.event_location, ed.event_overview, a.area_name, a.city_name, ed.event_cost, ed.viewer_count, ed.priority_count, ed.category_name, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.is_active = 1 and es.event_date between '{$from_date}' and '{$to_date}' and ed.event_name='{$searchParam}' group by ed.event_detail_id order by ed.priority_count, ed.viewer_count LIMIT {$index},3";
            }
        }

        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0)
        {
            $i = 0;
            while($row = $temp->fetch_assoc())
            {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['area_name'];
                $rows[$i]['event_city'] = $row['city_name'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = array();
                $rows[$i]['event_hashtags'] = explode(' ',$row['event_hashtags']);
                if($row['schedule'])
                {
                    $temp_date_array = explode(',',$row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];

                        $y = explode('-',$z['date']);
                        $z['day'] = $y[0];
                        $z['month'] = $y[1];
                        $z['year'] = $y[0];

                        $y = explode(':',$z['start_time']);
                        $z['start_time_hour'] = $y[0];
                        $z['start_time_min'] = $y[1];

                        $y = explode(':',$z['end_time']);
                        $z['end_time_hour'] = $y[0];
                        $z['end_time_min'] = $y[1];

                        array_push($rows[$i]['datetime'] , $z);
                    }
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }

                if($row['image'])
                {
                    $temp_image_array = explode(',',$row['image']);
                    $y = array();
                    foreach ($temp_image_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['image_path'] = $y[0];
                        $z['primary'] = $y[1];
                        array_push($rows[$i]['image'] , $z);
                    }
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
            $result['message'] = 'No Events Found';
            $result['data'] = '';
            return $result;

        }

    }

    /**
     * This function takes organiser_id as input and based on this it fires a SELECT query to
     * fetch data of all the events belonging to the particular Organiser.
     * The date and time is stored as arrays in an outer array. Same is done for storing the
     * Image URL's.Thus the entire result is sent back as a multidimensional array.
     */

    public function getEventDetail($event_detail_id)
    {
        $db = $this->getDatabaseObject();
        $query = "select ed.event_detail_id,ed.venue_name, ed.event_name, ed.event_overview, ed.event_hashtags, ed.event_location, a.area_id, a.area_name, a.city_name, ed.event_cost, ed.category_name, ed.viewer_count, ed.priority_count, GROUP_CONCAT(DISTINCT CONCAT_WS('=', es.event_date, es.event_start_time, es.event_end_time)) as schedule,  GROUP_CONCAT(DISTINCT CONCAT_WS('=', ei.event_image_name, ei.primary_image)) as image from event_detail ed, event_schedule es, event_image ei, area a where ed.event_detail_id = es.event_detail_id and ed.event_detail_id = ei.event_detail_id and ed.event_area_id = a.area_id and ed.is_active = 1 and ed.event_detail_id = '{$event_detail_id}'";

        $temp = $db->query($query);
        $result =array();
        if($temp->num_rows>0)
        {
            $i = 0;
            while($row = $temp->fetch_assoc())
            {
                $rows[$i]['category_name'] = $row['category_name'];
                $rows[$i]['event_area'] = $row['area_name'];
                $rows[$i]['event_city'] = $row['city_name'];
                $rows[$i]['event_cost'] = $row['event_cost'];
                $rows[$i]['event_detail_id'] = $row['event_detail_id'];
                $rows[$i]['event_location'] = $row['event_location'];
                $rows[$i]['event_name'] = $row['event_name'];
                $rows[$i]['event_overview'] = htmlspecialchars_decode(stripslashes($row['event_overview']));
                $rows[$i]['venue_name'] = $row['venue_name'];
                $rows[$i]['datetime'] = array();
                $rows[$i]['image'] = array();
                $rows[$i]['event_hashtags'] = explode(' ',$row['event_hashtags']);
                if($row['schedule'])
                {
                    $temp_date_array = explode(',',$row['schedule']);
                    $y = array();
                    foreach ($temp_date_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['date'] = $y[0];
                        $z['start_time'] = $y[1];
                        $z['end_time'] = $y[2];

                        $y = explode('-',$z['date']);
                        $z['day'] = $y[0];
                        $z['month'] = $y[1];
                        $z['year'] = $y[0];

                        $y = explode(':',$z['start_time']);
                        $z['start_time_hour'] = $y[0];
                        $z['start_time_min'] = $y[1];

                        $y = explode(':',$z['end_time']);
                        $z['end_time_hour'] = $y[0];
                        $z['end_time_min'] = $y[1];

                        array_push($rows[$i]['datetime'] , $z);
                    }
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Schedule not fetched properly';
                    return $result;
                }

                if($row['image'])
                {
                    $temp_image_array = explode(',',$row['image']);
                    $y = array();
                    foreach ($temp_image_array as $x)
                    {
                        $y = explode('=',$x);
                        $z = array();
                        $z['image_path'] = $y[0];
                        $z['primary'] = $y[1];
                        array_push($rows[$i]['image'] , $z);
                    }
                    $i++;
                }
                else
                {
                    $result['status'] = 'failure';
                    $result['message'] = 'Event Image URL\'s not fetched Properly';
                    return $result;
                }
            }

            $result['status'] = 'success';
            $result['message'] = 'Event Details successfully fetched';
            $result['data'] = $rows;
            return $result;
        }
        else {
            $result['status'] = "failure";
            $result['message'] = 'No Events Found';
            $result['data'] = '';
            return $result;

        }
    }

    public function socialUserLogin($username, $emailId, $dob, $city, $socialLoginId, $socialLoginService)
    {
        $db = $this->getDatabaseObject();
        $user_name = (isset($username) && $username!=null )?$db->real_escape_string($username):'';
        $user_email_id = (isset($emailId) && $emailId!=null )?$db->real_escape_string($emailId):'';
        $user_dob = (isset($dob) && $dob!=null )?$db->real_escape_string($dob):'';
        $user_city = (isset($city) && $city!=null )?$db->real_escape_string($city):'';
        $social_login_id = (isset($socialLoginId) && $socialLoginId!=null )?$db->real_escape_string($socialLoginId):'';
        $social_login_service = (isset($socialLoginService) && $socialLoginService!=null )?$db->real_escape_string($socialLoginService):'';

        $query = "select * from user_login where social_login_id = '{$social_login_id}'";

        $temp = $db->query($query);
        $result = array();

        if($temp->num_rows>0)
        {
            $result['status'] = 'success';
            $result['data'] = $temp;
        }
        else
        {
            $query = "INSERT INTO 'user_login' ('user_name', 'user_email_id', 'user_dob', 'user_city', 'social_login_id', 'social_login_service') VALUES ('{$user_name}','{$user_email_id}','{$user_dob}','{$user_city}',{$social_login_id},'{$social_login_service}')";

            $temp = $db->query($query);
            $result = array();

            if($temp){
                $result['status'] = 'success';
                $result['data'] = 'Data Inserted Successfully';
            }
            else {
                $result['status'] = 'failure';
                $result['data'] = 'There was problem saving the data';
            }
        }
    }

}

