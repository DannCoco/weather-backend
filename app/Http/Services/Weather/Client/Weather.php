<?php

namespace App\Http\Services\Weather\Client;

class Weather
{
    private $url;
    
    public function __construct()
    {
        $this->url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';
    }

    public function get(String $location = "")
    {
        $url = $this->url;
        $app_id = 'v08Nw4CZ';
        $consumer_key = 'dj0yJmk9MThya3dHeWNwVUppJmQ9WVdrOWRqQTRUbmMwUTFvbWNHbzlNQT09JnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PWJi';
        $consumer_secret = '1951fa04e7d9a70cf0c4d0094f61b18d61ee7a88';

        $query = [
            'location' => (!empty($location)) ? $location : "",
            'format' => 'json'
        ];

        $oauth = [
            'oauth_consumer_key' => $consumer_key,
            'oauth_nonce' => uniqid(mt_rand(1, 1000)),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        ];

        $base_info = $this->buildBaseString($url, 'GET', array_merge($query, $oauth));
        $composite_key = rawurlencode($consumer_secret) . '&';
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth['oauth_signature'] = $oauth_signature;

        $header = [
            $this->buildAuthorizationHeader($oauth),
            'X-Yahoo-App-Id: ' . $app_id
        ];

        $options = [
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $url . '?' . http_build_query($query),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        ];

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }

    protected function buildBaseString($baseURI, $method, $params)
    {
        $r = [];
        ksort($params);
        foreach($params as $key => $value) {
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    }

    protected function buildAuthorizationHeader($oauth) 
    {
        $r = 'Authorization: OAuth ';
        $values = [];
        
        foreach($oauth as $key=>$value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }

        $r .= implode(', ', $values);
        return $r;
    }
}