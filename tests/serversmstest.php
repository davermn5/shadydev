<?php
  require_once('../ServerSMS.php');
  class ServerSMSTest extends PHPUnit_Framework_TestCase{
   protected $_serverSMS = null;
   protected $hosts = array();
   protected $head  = '';  
   
   public function __construct(){}
   
   public function setUp(){
    $this->_serverSMS = new ServerSMS();
   }
   
   public function tearDown(){
    unset($this->_serverSMS);
   }
   
   public function testHostNameIsSet(){
    $this->assertEmpty($this->hosts);
     array_push($this->hosts, 'www.google.com');
     array_push($this->hosts, 'www.gorags1234.com');   //Will become $this->head..
   $this->assertContainsOnly('string', $this->hosts);
   
   $this->head = array_pop($this->hosts);
   $this->assertNotEquals($this->head, $this->hosts[count($this->hosts)-1] );
   
   } //end testHostNameIsSet()..
   
   
    public function testGetHostLatency(){
      $latency = $this->_serverSMS->getHostLatency($this->head); 
      PHPUnit_Framework_Assert::assertNotNull($latency);
    }
           
  }//end ServerSMSTest class..
?>
