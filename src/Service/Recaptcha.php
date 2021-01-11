<?php

namespace BrunoGrosdidier\Blog\src\Service;

class Recaptcha
{
    private $recaptchaFormResponse;

    public function verifyRecaptcha($recaptchaFormResponse)
    {
        // Recaptcha URL
        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify?secret="
                        . SECRET_KEY
                        . "&response={$recaptchaFormResponse}";

        // Check if curl is installed
        if (function_exists('curl_version')) {
            $curl = curl_init($recaptchaUrl);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            //curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // debug
            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                //var_dump(curl_error($curl)); // debug
            }
            curl_close($curl);
        } else {
            // Use of file_get_contents
            $response = file_get_contents($recaptchaUrl);
        }

        // Check if response
        if (empty($response) || is_null($response)) {
            return 'error';
        } else {
            $data = json_decode($response);
            if ($data->success) {
                return 'success';
            } else {
                return 'error';
            }
        }
    }
}
