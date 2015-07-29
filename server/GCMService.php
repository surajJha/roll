<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/7/15
 * Time: 1:31 PM
 */
require_once 'MakeCurlRequest.php';
require_once 'databaseConnection.php';
class GCMService
{
    const GCM_API_URL = '';
    const GCM_APP_KEY = '';

    public function __construct(){

    }

    public function sendPushMessageToDevices($regIdOfDevices, $message){
        $header = array(
            "Authorization", "key=".self::GCM_APP_KEY,
            "Content-Type", "application/x-www-form-urlencoded;charset=UTF-8"
        );
        $curlObj = new MakeCurlRequest();
        if($message !=null){
            foreach($regIdOfDevices as $key => $value){
                $curlObj->makePostRequest(self::GCM_API_URL, $message, $header);
            }
        }

    }

    public function getDeviceRegistrationsIds(){

    }

    public function setDeviceRegistrationId($device_id, $gcm_registration_id){

    }

    public function updateDeviceRegistrationId($device_id, $gcm_registration_id){

    }
}