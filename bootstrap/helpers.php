<?php

use App\Services\Response;

if ( ! function_exists('apiResponse')) {
    /**
     * apiResponse
     *
     * @return Response
     */
    function apiResponse(): Response
    {
        return app('api-response');
    }
}

if ( ! function_exists('generateUniqueNumber')) {
    /**
     * generateUniqueNumber
     *
     * @param int $length
     * @return int
     * @throws Exception
     */
    function generateUniqueNumber(int $length = 10): int
    {
        do {
            $length = max(1, $length);

            $min = pow(10, $length - 1);
            $max = pow(10, $length) - 1;

            $microTime = str_replace('.', '', microtime(true));
            $uniqueId = random_int(11111111, 99999999).(hexdec(uniqid()) % ($max - $min + 1)).$microTime;

            $digits = str_split($uniqueId);

            shuffle($digits);

            $uniqueId = substr(implode('', $digits), 0, $length);
        } while (str_starts_with($uniqueId, '0') or strlen($uniqueId) > $length or strlen($uniqueId) < $length);

        return $uniqueId;
    }
}
