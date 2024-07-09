<?php namespace App\Libraries;

class SendSms{
  public function sendMessage($ph,$msg ,$origin=null){
     
    require_once __DIR__ . '/Smsglobal/vendor/autoload.php';

     // get your REST API keys from MXT https://mxt.smsglobal.com/integrations
    \SMSGlobal\Credentials::set('6496e3c02b348985878674d0fa1b2f23', 'b6a1090cc5c2a91f0d286d6574ea574c');

    $otp = new \SMSGlobal\Resource\Otp();

    try {
        // $response = $sms->sendToOne($ph, $msg);
        $response = $otp->send($ph, $msg , $origin);

        // return ($response['messages']);
        return ($response);

    
    } 

    catch (\Exception $e) {
       return $e->getMessage();
    }
      
  }

  public function verifyotp($reqid, $code){
    require_once __DIR__ . '/Smsglobal/vendor/autoload.php';
    // get your REST API keys from MXT https://mxt.smsglobal.com/integrations
    \SMSGlobal\Credentials::set('6496e3c02b348985878674d0fa1b2f23', 'b6a1090cc5c2a91f0d286d6574ea574c');

    $otp = new \SMSGlobal\Resource\Otp();

    try {
      $response = $otp->verifyByRequestId($reqid, $code);
      // print_r($response);
      return $response;
    } 
    
    catch (\Exception $e) {
      echo $e->getMessage();
    }
  }
} 