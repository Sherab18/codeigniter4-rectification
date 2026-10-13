<?php
function verifyCaptcha($remoteIp, $response)
{
    $secret = '6Ld_y2wqAAAAAB3qolvcZaR_TmIHY249evlVbDa7';
    $recaptchaUrl = 'https://www.google.com/recaptcha/api/siteverify';

    // Prepare POST data
    $postData = http_build_query([
        'secret'   => $secret,
        'response' => $response,
        'remoteip' => $remoteIp
    ]);

    // Initialize cURL
    $curl = curl_init($recaptchaUrl);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

    // Execute the request
    $recaptchaResponse = curl_exec($curl);

    curl_close($curl);

    // Handle failure
    if ($recaptchaResponse === false) {
        return false;
    }

    $recaptcha = json_decode($recaptchaResponse);

    // Return true if reCAPTCHA is valid
    return ($recaptcha && isset($recaptcha->success) && $recaptcha->success);
}
