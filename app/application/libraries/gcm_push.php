<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
/*
    Class to send push notifications using Google Cloud Messaging for Android

    -----------------------
    Example usage
    -----------------------
    $an = new gcmpushmessage($api_server_key);
    $an->setDevices($devices);
    $response = $an->send($message);
    -----------------------
    
    $api_server_key Your GCM api key
    $devices An array or string of registered device tokens
    $message The mesasge you want to push out

    @author Matt Grundy

    Adapted from the code available at:
    http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging

    -----------------------
    Sample code
    -----------------------
    $api_server_key = 'AIzaSyCc0_h7Jwmgcil7TkDWeVHsgcho2Ic2HGI';
    $devicetoken    = array('APA91bGdvq4-8QsZUgBtK9gnp7UShvhZKw3EGTBNAdzhlDNy9irD48oMFCHrKI588werVjKkeLxDKGP1DqeMeJA4qrwnCRscC3X1LSCZ63Ba4uDbcSvphh0Fjl2wNYe9c1IboXQIWJn27R4DBK-2p3bd9qYdamqpbQ');

    $message=array(
        'title'   => 'title',
        'link'    => 'link',
        'message' => 'message'
    );

    $gcm = new Gcm_push($api_server_key);
    echo $gcm->push_notification($devicetoken, $message);
*/
class Gcm_push
{
    /*
    Set the api key for using push service.
    Note that if you send by "cUrl" , you should ask a "Browser Key"!
    $api_server_key = "";
    */
    var $GOOGLE_API_KEY         = '';
    var $GOOGLE_CLOUD_MESSAGING = 'https://android.googleapis.com/gcm/send'; // Google Cloud Messaging Service path for push notification 
    var $contentType            = 'application/json'; // content type for your data format
    
    public function __construct ($api_server_key = '')
    {
        $this->GOOGLE_API_KEY = $api_server_key;
    }
    
    /* the main function to send message */
    public function push_notification($device_token_array = '', $message = '', $notifyType = '')
    {
        /* 
            there are example data.
            if un note this section , you can use some fake data for testign 
            $device_token_array  = array("50");
            $notifyType = "packages";
        */
        if(!is_array($device_token_array)) { $device_token_array = array($device_token_array); }
        
        //if data is null , then return false 
        if( count($device_token_array) <= 0 /*or trim($message) == ""*/) 
        {
            return false; 
        }
        
        $push_messagess = $message['title']."@@".$message['link']."@@".$message['message'];

        $post_fields = array(
            'data' => array(
                'action'   => $push_messagess,
                "dataType" => $notifyType
            ),
            'registration_ids' => $device_token_array
        );
        $post_fields = json_encode($post_fields);
        
        $aciton = array( 
            "Content-Type: ".$this->contentType ,
            "Authorization: key=".$this->GOOGLE_API_KEY
        );

        /* initial the curl object */
        $curl = curl_init();
        curl_setopt($curl , CURLOPT_URL , $this->GOOGLE_CLOUD_MESSAGING);
        curl_setopt($curl , CURLOPT_POST , true );
        curl_setopt($curl , CURLOPT_RETURNTRANSFER , true );
        curl_setopt($curl , CURLOPT_SSL_VERIFYPEER , false );
        curl_setopt($curl , CURLOPT_HTTPHEADER  , $aciton );
        curl_setopt($curl , CURLOPT_POSTFIELDS ,$post_fields);
        $curl_result = curl_exec( $curl );

        if($curl_result)
        {
            return json_decode($curl_result, true);
        }
        else
        {
            return false;
        }
    }
}