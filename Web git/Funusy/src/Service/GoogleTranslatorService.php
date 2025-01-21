<?php

// src/Service/GoogleTranslatorService.php

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GoogleTranslatorService
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function translate(string $langFrom, string $langTo, string $word): string
    {
        try {
            $url = "http://translate.googleapis.com/translate_a/single?client=gtx&" .
                "sl=" . $langFrom .
                "&tl=" . $langTo .
                "&dt=t&q=" . urlencode($word);

            $response = $this->client->request('GET', $url);
            $content = $response->getContent();

            // Parse the translation result from JSON
            $translatedText = $this->parseResult($content);

            return $translatedText;
        } catch (Exception $e) {
            // Handle exceptions (e.g., network errors, invalid response)
            // You might want to log the error or handle it differently
            throw new Exception("An error occurred while translating the text: " . $e->getMessage());
        }
    }

    private function parseResult(string $inputJson): string
    {
        $translatedText = "";
        $parts = explode('"', $inputJson);
        if (count($parts) >= 2) {
            $translatedText = $parts[1];
        }
        return $translatedText;
    }
}
