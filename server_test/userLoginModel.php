<?php
/**
 * Created by PhpStorm.
 * User: neha
 * Date: 18/7/15
 * Time: 4:33 PM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'userUtil.php';

class UserLoginModel
{
    protected $userUtil = '';

    public function __construct()
    {
        $this->userUtil = new UserUtil();
    }


    public function socialUserLogin($user_id, $username, $emailId, $dob, $city, $socialLoginId, $socialLoginService)
    {
        $db = $this->userUtil->getDatabaseObject();
        $user_id = (isset($user_id) && $user_id!=null )?$user_id:'';
        $user_name = (isset($username) && $username!=null )?$username:'';
        $user_email_id = (isset($emailId) && $emailId!=null )?$emailId:'';
        $user_dob = (isset($dob) && $dob!=null )?$dob:'';
        $user_city = (isset($city) && $city!=null )?$city:'';
        $social_login_id = (isset($socialLoginId) && $socialLoginId!=null )?$socialLoginId:'';
        $social_login_service = (isset($socialLoginService) && $socialLoginService!=null )?$socialLoginService:'';

        $query = "select * from user_login where social_login_id = '{$social_login_id}'";
        $temp = $db->query($query);
        $result = array();
        $rows = array();
        if($temp->num_rows>0)
        {
            while($row = $temp->fetch_assoc())
            {
                $rows = $row;
            }
            $result['status'] = 'success';
            $result['data'] = $rows;
        }
        else
        {
            $query = "INSERT INTO user_login (user_id, user_name, user_email_id, user_dob, user_city, social_login_id, social_login_service) VALUES ('{$user_id}','{$user_name}','{$user_email_id}','{$user_dob}','{$user_city}','{$social_login_id}','{$social_login_service}')";
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

        return $result;
    }
}