<?php
namespace App\Service;

require __DIR__. '/vendor/autoload.php';
use Twilio\Rest\Client;
use App\Entity\CarteBancaire;
use DateTime;
class TwilioService
{
    private $twilioSid;
    private $twilioToken;
    private $twilioPhoneNumber;

    public function __construct(string $twilioSid, string $twilioToken, string $twilioPhoneNumber)
    {
        $this->twilioSid = $twilioSid;
        $this->twilioToken = $twilioToken;
        $this->twilioPhoneNumber = $twilioPhoneNumber;
    }

    public function sendreminder(CarteBancaire $carte): void
    {
        $sid = $this->twilioSid;
        $token = $this->twilioToken;
        $twilio = new Client($sid, $token);
       
        $messageBody = 'Dear custorm,we wanted to inform you that your card is gonna be expired in !!';
         $message = $twilio->messages
            ->create("+21652715672", 
                array(
                    "from" => "+13184060130",
                    "body" => $messageBody,
                )
            );
    }

}
