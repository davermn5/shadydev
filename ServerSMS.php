<?php
	/**
	 * The purpose of this class is to provide an ajax response which notifies the user
	 *  if the website is up or down.
	 *
	 * @author  davermn5
	 * @version 0.1.0
	 *
	 * May 15th 2013
	 */
	require_once('ping.php');
	require_once('twilio/Services/Twilio.php');

	class ServerSMS
	{
		/**
		 * @var string
		 */
		protected $target_host = "";

		public function __construct()
		{
		}

		/**
		 * Gets the amount of time taken to ping a remote host
		 *
		 * @param  string $target_host Represents the remote server host we wish to ping
		 *
		 * @return integer | boolean
		 *  Returns either the number of milliseconds upon success or
		 *  false if the remote server is down.
		 */
		public function getHostLatency($target_host)
		{
			$this->target_host = $target_host;
			$ping = new Ping($target_host);
			$latency = $ping->ping();

			return $latency;
		}


		/**
		 * @param string $AccountSid  Represents the first Twilio authentication credential (1/2).
		 * @param string $AuthToken   Represents the second Twilio authentication credential (2/2).
		 * @param array $toList       Describes a multi-dimensional array of stringified key=>value pairs.
		 *                            The values are the phone numbers you wish to send text notifications to.
		 * @param $sandboxNumber      This is the Twilio sandbox number provided to you upon initial Twilio account creation.
		 */
		public function serverIsDown($AccountSid, $AuthToken, $toList, $sandboxNumber)
		{
			$client = new Services_Twilio($AccountSid, $AuthToken);

			foreach ($toList as $number => $name) {
				$serverDownMessage = "Hey " . $name . ", the server at " . $this->target_host . " is down.";
				$sms = $client->account->sms_messages->create($sandboxNumber, $number, $serverDownMessage);
			}
		}
	}


//Here are the instructions to call the public wrapper API to Twilio REST service:
	$hosts = array('www.google.com', 'www.gorags1234.com');
	$head = array_pop($hosts);
	$serverA = new ServerSMS();

	if(!is_null($latency = $serverA->getHostLatency($head)))
	{
		if ($latency > 0) //Server is up..
		{
			echo 1;
		}
		elseif ($latency === FALSE) //Server is down.. Only activate SMS service during downtime.
		{
			//Enter Twilio creds here:
			$AccountSid = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
			$AuthToken = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";

			//Enter List of phone #'s and names here:
			$toList = array(
				'+yournumberhere' => "yournamehere"
			);

			//Enter Twilio sandbox # here:
			$sandboxNumber = "xxx-xxx-xxxx";

			$serverA->serverIsDown($AccountSid, $AuthToken, $toList, $sandboxNumber);
			echo 0; //Ajax callback value..
		}
	}