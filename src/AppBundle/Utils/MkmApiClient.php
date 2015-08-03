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

    public function getCard($cardName)
    {
        //$url                = "https://www.mkmapi.eu/ws/v1.1/output.json/games";
        $url                = "https://www.mkmapi.eu/ws/v1.1/output.json/products/".$cardName."/".self::MKM_MTG_ID."/1/false";

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
        $apiOutput[2]        = $decoded;

        return $apiOutput;
    }

    public function getCardPrice($cardName)
    {
        $cards = $this->getCard($cardName)[2]['product'];
        $cheapest = array_reduce($cards, function($a, $b) {
            if (
                $a['idGame'] != self::MKM_MTG_ID
                || !array_key_exists('rarity', $a)
                || $a['rarity']=='Special'
                || $a['rarity']=='Token')
            {
                return $b;
            }
            if (
                $b['idGame'] != self::MKM_MTG_ID
                || !array_key_exists('rarity', $b)
                || $b['rarity']=='Special'
                || $b['rarity']=='Token')
            {
                return $a;
            }
            return $a['priceGuide']['AVG'] < $b['priceGuide']['AVG'] ? $a : $b;
        }, array_shift($cards));
        $productId = $cheapest['idProduct'];
        //return $cheapest;

        $url                = "https://www.mkmapi.eu/ws/v1.1/output.json/articles/".$productId;

        $apiOutput          = $this->doApiRequest($url);
        $decoded            = json_decode($apiOutput[1], true);

        $prices = [];
        foreach ($decoded['article'] as &$article)
        {
            if ($article['isFoil']==false
                and $article['isAltered']==false
                and $article['isSigned']==false
                and $article['isPlayset']==false
            )
            {
                $prices[] = $article['price'];
            }
        }

        $average = array_sum($prices) / count($prices);
        $wo_outliers = $this->remove_outliers($prices);
        $standard = array_sum($wo_outliers) / count($wo_outliers);

        return $standard;
    }

    private function remove_outliers($dataset, $magnitude = 1) {

        $count = count($dataset);
        $mean = array_sum($dataset) / $count; // Calculate the mean
        $deviation = stats_standard_deviation($dataset) * $magnitude; // Calculate standard deviation and times by magnitude

        return array_filter($dataset, function($x) use ($mean, $deviation) { return ($x <= $mean + $deviation && $x >= $mean - $deviation); }); // Return filtered array of values that lie within $mean +- $deviation.
    }
}

if (!function_exists('stats_standard_deviation')) {
    /**
     * This user-land implementation follows the implementation quite strictly;
     * it does not attempt to improve the code or algorithm in any way. It will
     * raise a warning if you have fewer than 2 values in your array, just like
     * the extension does (although as an E_USER_WARNING, not E_WARNING).
     * 
     * @param array $a 
     * @param bool $sample [optional] Defaults to false
     * @return float|bool The standard deviation or false on error.
     */
    function stats_standard_deviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }
}
