<?php

namespace Eaglewatch\Search\Abstracts;

use Exception;
use GuzzleHttp\Client;


abstract class HttpRequest
{
    protected string $baseUrl, $apiKey;
    protected $client;
    protected $response;
    protected array $additionalHeader = [];

    private $requestOptions = [];

    protected function setApiUrl($apiBaseUrl): void
    {
        $this->baseUrl = $apiBaseUrl;
    }

    protected function setApiKey($key): void
    {
        $this->apiKey = $key;
    }

    protected function setRequestOptions()
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            ...$this->additionalHeader
        ];
        $this->client = new Client(
            [
                'base_uri' => $this->baseUrl,
                'headers' => $headers
            ]
        );
    }

    protected function setHttpResponse($relativeUrl, $method, $body = [], $params=[])
    {

        try{
        if (is_null($method)) {
            throw new Exception("Request method must be specified");
        }

        if ($method === 'GET' && !empty($params)) {
            $this->requestOptions['query'] = $params;
        }
        
        // Add JSON body for non-GET requests
        if ($method !== 'GET' && !empty($body)) {
            $this->requestOptions['body'] = json_encode(  $body);
        }
        
        $this->response = $this->client->{strtolower($method)}(
            $this->baseUrl .  (string)$relativeUrl,
            $this->requestOptions
        );
        


        return $this;

       }catch (Exception $e){

        throw new Exception($e->getMessage(), $e->getCode());
       }
    }



    protected function getResponse()
    {
           
        
        $data = json_decode($this->response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode JSON: " . json_last_error_msg());
        }
        return $data;
    }

    protected function getFileContent($url)
    {
        $jsonData = @file_get_contents($url);
        if ($jsonData === FALSE) {
            throw new Exception("Unable to fetch data from $url");
        }

        $data = json_decode($jsonData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Failed to decode JSON: " . json_last_error_msg());
        }

        return $data;
    }
}
