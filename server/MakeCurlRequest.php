<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 29/7/15
 * Time: 1:44 PM
 */

class MakeCurlRequest
{
    public function __construct(){}

    public function makePostRequest($url, $postData, $header='')
    {
        $fields_string = '';
        foreach ($postData as $key => $value) {
            $fields_string .= $key . '=' . $value . '&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        if(isset($header) && $header !== null && $header !== ''){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec($ch);
        if(curl_errno($ch)){
            die('Couldn\'t send request: ' . curl_error($ch));
        }
        else {
            // check the HTTP status code of the request
            $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($resultStatus != 200) {
                die('Request failed: HTTP status code: ' . $resultStatus);
            }
        }
        curl_close($ch);
    }

    public function makeGetRequest(){

    }
}
