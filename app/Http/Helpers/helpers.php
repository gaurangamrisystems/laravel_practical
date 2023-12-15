<?php

if (! function_exists('makeCurlRequest')){
    function makeCurlRequest($url, $method = 'GET', $headers = [],$data = null ) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        if (($method !== 'GET')||($method !== 'DELETE')) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if ($data !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Assuming you're sending JSON data
                curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge(['Content-Type: application/json'], $headers));
            }
        }
        $response = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $error_message = 'Curl error: ' . curl_error($ch);
            curl_close($ch);
            return ['error' => $error_message, 'http_status' => $http_status];
        }    
        curl_close($ch);    
        if ($http_status < 200 || $http_status >= 300) {
            return ['error' => "HTTP error: {$http_status}", 'http_status' => $http_status,'message'=>(!empty($response) && json_decode($response,true)['message'])?json_decode($response,true)['message']:'-'];
        }
        return ['response' => $response, 'http_status' => $http_status];
       
    }
}
?>