<?php
namespace App\Utils;

class RecaptchaUtils
{
    const API_URL = "https://www.google.com/recaptcha/api/siteverify";

    public function __construct($recaptchaSecretKey, $recaptchaPublicKey)
    {
        $this->secretKey = $recaptchaSecretKey;
        $this->pulicKey = $recaptchaPublicKey;
    }

    public function check($captcha = '', $ip = NULL) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, RecaptchaUtils::API_URL);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, array(
            "secret"=>$this->secretKey,"response"=>$captcha));
        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);

        return $data->success;
    }
}
