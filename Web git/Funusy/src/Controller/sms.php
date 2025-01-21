<?php
namespace App\Service;

require __DIR__. '/vendor/autoload.php';
use Twilio\Rest\Client;
use App\Entity\Credit;

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

    public function sendCongratulationsSMS(Credit $credit): void
    {
        $sid = $this->twilioSid;
        $token = $this->twilioToken;
        $twilio = new Client($sid, $token);

        // Définir le message en fonction du statut du crédit
        $messageBody = $credit->getStatus() === 'Accepted' ? 'Votre crédit a été accepté.' : 'Votre crédit a été rejeté.';

        // Envoyer le message Twilio
        $message = $twilio->messages
            ->create("+21652715672", // to
                array(
                    "from" => "+13184060130",
                    "body" => $messageBody,
                )
            );
    }

}