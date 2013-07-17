Wrapper API for Twilio REST Service
========
SMS (text) user's cell phone(s) in case a remote server accessible via 'http' becomes unavailable (is down).
(Note: If the website is up, no text message will be sent).


Installation
============

First,  git clone https://github.com/davermn5/shadydev.git wrapperTwilioPHP

Second, sign up a for a free trial account with twilio.com:
http://www.twilio.com/

Third, inside ServerSMS.php :
~ line 59:  $hosts = array('www.google.com', 'www.websiteyouwanttomonitor.com');
(Note: www.google.com is just a placeholder for testing)


(Inside Twilio account settings) go place the following here:
$AccountSid = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$AuthToken = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";


Fill in the list of cell phone recipients
    $toList = array(
                 '+1yournumberhere' => "yournamehere"
    );


Lastly, enter your Twilio sandbox # here:
$sandboxNumber = "xxx-xxx-xxxx"; 

Install questions or enhancements feel free email davermn5 at gmail dot com

