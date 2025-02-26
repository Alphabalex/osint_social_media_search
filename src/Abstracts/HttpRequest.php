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

    protected  $noOfRetries = 2;

    protected $sleepTime = 10;

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
         $numOfAttempt = 0;
       
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
        
        while($numOfAttempt < $this->noOfRetries){
            echo " {$numOfAttempt }";
            try{
                $this->response = $this->client->{strtolower($method)}(
                $this->baseUrl .  (string)$relativeUrl,
                $this->requestOptions
            );


                
                return $this;

            }catch (Exception $e){

                $statusCode = $e->getCode();

                if($statusCode >= 500&& $statusCode < 600){
                    $numOfAttempt++;

                 $className = class_basename($this);
                
                 Log::info("500 error code, retring after {$this->sleepTime} for class {$className}");

                    if($numOfAttempt < $this->noOfRetries){

                        sleep($this->sleepTime);

                    }else{

                        throw $e;
                    }


                }else{

                throw $e;
                }

            }
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
