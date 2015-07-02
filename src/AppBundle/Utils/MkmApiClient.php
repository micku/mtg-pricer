<?php

namespace AppBundle\Utils;

class MkmApiClient
{
    const MKM_MTG_ID = '1';

    private static $instance = NULL;

    protected $appToken;
    protected $appSecret;
    protected $accessToken;
    protected $accessSecret;

    public static function getInstance($appToken, $appSecret, $accessToken, $accessSecret)
    {
        if(is_null(self::$instance))
        {
            self::$instance = new self();
            self::$instance->appToken = $appToken;
            self::$instance->appSecret = $appSecret;
            self::$instance->accessToken = $accessToken;
            self::$instance->accessSecret = $accessSecret;
        }
        return self::$instance;
    }

    protected function getHeaders($url) {
        $method             = "GET";
        $nonce              = uniqid();
        $timestamp          = time();
        $signatureMethod    = "HMAC-SHA1";
        $version            = "1.0";

        /**
         * Gather all parameters that need to be included in the Authorization header and are know yet
         *
         * @var $params array|string[] Associative array of all needed authorization header parameters
         */
        $params             = array(
            'realm'                     => $url,
            'oauth_consumer_key'        => $this->appToken,
            'oauth_token'               => $this->accessToken,
            'oauth_nonce'               => $nonce,
            'oauth_timestamp'           => $timestamp,
            'oauth_signature_method'    => $signatureMethod,
            'oauth_version'             => $version,
        );

        /**
         * Start composing the base string from the method and request URI
         *
         * @var $baseString string Finally the encoded base string for that request, that needs to be signed
         */
        $baseString         = strtoupper($method) . "&";
        $baseString        .= rawurlencode($url) . "&";

        /*
         * Gather, encode, and sort the base string parameters
         */
        $encodedParams      = array();
        foreach ($params as $key => $value)
        {
            if ("realm" != $key)
            {
                $encodedParams[rawurlencode($key)] = rawurlencode($value);
            }
        }
        ksort($encodedParams);

        /*
         * Expand the base string by the encoded parameter=value pairs
         */
        $values             = array();
        foreach ($encodedParams as $key => $value)
        {
            $values[] = $key . "=" . $value;
        }
        $paramsString       = rawurlencode(implode("&", $values));
        $baseString        .= $paramsString;

        /*
         * Create the signingKey
         */
        $signatureKey       = rawurlencode($this->appSecret) . "&" . rawurlencode($this->accessSecret);

        /**
         * Create the OAuth signature
         * Attention: Make sure to provide the binary data to the Base64 encoder
         *
         * @var $oAuthSignature string OAuth signature value
         */
        $rawSignature       = hash_hmac("sha1", $baseString, $signatureKey, true);
        $oAuthSignature     = base64_encode($rawSignature);

        $params['oauth_signature'] = $oAuthSignature; 

        /*
         * Construct the header string
         */
        $header             = "Authorization: OAuth ";
        $headerParams       = array();
        foreach ($params as $key => $value)
        {
            $headerParams[] = $key . "=\"" . $value . "\"";
        }
        $header            .= implode(", ", $headerParams);

        return $header;
    }

    protected function doApiRequest($url)
    {
        /*
         * Include the OAuth signature parameter in the header parameters array
         */
        $header = $this->getHeaders($url); //$oAuthSignature;

        /*
         * Get the cURL handler from the library function
         */
        $curlHandle         = curl_init();

        /*
         * Set the required cURL options to successfully fire a request to MKM's API
         *
         * For more information about cURL options refer to PHP's cURL manual:
         * http://php.net/manual/en/function.curl-setopt.php
         */
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array($header));
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

        /**
         * Execute the request, retrieve information about the request and response, and close the connection
         *
         * @var $content string Response to the request
         * @var $info array Array with information about the last request on the $curlHandle
         */
        $content            = curl_exec($curlHandle);
        $info               = curl_getinfo($curlHandle);
        curl_close($curlHandle);

        return array($info, $content);
    }

    /**
     * @Route("/test/", name="test")
     * @Method("GET")
     */
    public function getCard($cardName)
    {
        //$url                = "https://www.mkmapi.eu/ws/v1.1/output.json/games";
        $url                = "https://www.mkmapi.eu/ws/v1.1/output.json/products/".$cardName."/".self::MKM_MTG_ID."/1/true";

        /*
         * Convert the response string into an object
         *
         * If you have chosen XML as response format (which is standard) use simplexml_load_string
         * If you have chosen JSON as response format use json_decode
         *
         * @var $decoded \SimpleXMLElement|\stdClass Converted Object (XML|JSON)
         */
        $apiOutput          = $this->doApiRequest($url);
        $decoded            = json_decode($apiOutput[1], true);
        // $decoded            = simplexml_load_string($content);
        $apiOutput[2]        = $decoded;

        return $apiOutput;
    }

}
