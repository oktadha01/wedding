<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'target' => '089629310657',
        'message' => 'test message',
        'delay' => '2',
        'countryCode' => '62', //optional
    ),
    CURLOPT_HTTPHEADER => array(
        'Authorization: PPK3+BQuokovN16rcM2R' //change TOKEN to your actual token
    ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
