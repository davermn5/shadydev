<?php
  /**
  * Helpful utility created for shadyDev, Inc.
  *
  * @author davermn5
  * @version 0.1.0
  *
  * May 15th 2013
  */
  require_once('ping.php');
  require_once('twilio/Services/Twilio.php');
  class ServerSMS{
  
   protected $target_host = "";
   
   public function __construct(){}
   
   /*
   *  Method  getHostLatency()
   *  @Purpose Establish connection at tcp/ip layer
   *   @param  string  $target_host  The server we wish to gain status info from..
   *   
   *  @return  @mixed  int || FALSE  Either # millisecs(success) OR FALSE if server down(failure)          
   */      
   public function getHostLatency($target_host){
    $this->target_host = $target_host;
    $ping = new Ping( $target_host );
    $latency = $ping->ping();
    
    return $latency;
   }
   
   
   /*
   *  Method  serverIsDown()
   *  @Purpose If the server is down, have it do something useful..
   *   @param  string  $AccountSid     Twilio credential 1/2
   *   @param  string  $AuthToken      Twilio credential 2/2
   *   @param  array   $toList         An array of phone #'s you wish to send to
   *   @param  string  $sandboxNumber  Twilio sandbox number provided to you
   *   
   *  @return  void      
   */      
   public function serverIsDown( $AccountSid, $AuthToken, $toList, $sandboxNumber ){
    $client = new Services_Twilio($AccountSid, $AuthToken);
    
    foreach($toList as $number => $name){
     $serverDownMessage = "Hey " . $name . ", the server at " . $this->target_host . " is down.";
     $sms = $client->account->sms_messages->create( $sandboxNumber, $number, $serverDownMessage );
    } //end foreach..
    
   }//end serverIsDown()..
   
  }//end ServerSMS class..
  
  
  
  //Here are the instructions to call the public wrapper API to Twilio REST service:
  $hosts = array('www.google.com', 'www.gorags1234.com');
   $head = array_pop($hosts);
  $serverA = new ServerSMS();
  try{
   if( !is_null($latency = $serverA->getHostLatency($head)) )
   {
    if( $latency > 0)  //Server is up..
    {
     echo 1;
    }
    elseif( $latency === FALSE ) //Server is down.. Only activate SMS service during downtime.
    {
     //Enter Twilio creds here:
     $AccountSid = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
     $AuthToken  = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
    
     //Enter List of phone #'s and names here:
     $toList = array(
                  '+yournumberhere' => "yournamehere"
     );
    
     //Enter Twilio sandbox # here:
     $sandboxNumber = "xxx-xxx-xxxx";   
    
     $serverA->serverIsDown( $AccountSid, $AuthToken, $toList, $sandboxNumber );
     echo 0;   //Ajax callback value..
    }
   }
  }catch(Exception $e){
   echo $e->getMessage();
  }
  
  
  
  
?>
