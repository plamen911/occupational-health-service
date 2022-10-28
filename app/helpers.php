<?php

if (! function_exists('cleanText')) {
    function cleanText(?string $text): ?string
    {
        $cleanText = preg_replace('/[^A-Za-zА-я0-9 .,\-]/mu', '', (string) $text); // Removes special chars.

        return ! empty($cleanText) ? (string) $cleanText : null;
    }
}
