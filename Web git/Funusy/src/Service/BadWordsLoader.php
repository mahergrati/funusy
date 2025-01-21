<?php

// src/Service/BadWordsLoader.php

namespace App\Service;

class BadWordsLoader
{
    public static function loadBadWords(string $filePath): array
    {
        $badWordsList = [];

        try {
            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            if ($lines !== false) {
                foreach ($lines as $line) {
                    $badWordsList[] = trim($line);
                }
            }
        } catch (\Exception $e) {
            // Handle exception
            throw $e;
        }

        return $badWordsList;
    }
}
