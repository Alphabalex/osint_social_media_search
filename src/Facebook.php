<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;
use GuzzleHttp\Exception\RequestException;

class Facebook extends HttpRequest
{
    /**
     * Initializes the FacebookScraper class with API configuration.
     *
     * Sets the API URL using the domain URL from the Facebook Scraper configuration
     * and initializes additional headers.
     */
    public function __construct( ?string $api_key =  null )
    {
        $this->setApiUrl(getConfigSocial('app.facebook.api_url'));
        $this->additionalHeader = [
            'x-rapidapi-host' => getConfigSocial('app.facebook.x-rapidapi-host', ""),
            'x-rapidapi-key' => $api_key ? $api_key : getConfigSocial('app.facebook.x-rapidapi-key', ""),
        ];
        $this->setRequestOptions();
    }






    /**
     * Search for posts containing the given query.
     *
     * @param array $query =  (list of request params) {
     *  query =>
     *  location_uid =>
     * start_date => format(2024-11-14)
     * end_date=> 2025-02-14'
     * 
     * } The search query (e.g., 'facebook').
     *
     * @return array|null The API response, or null if the request fails.
     *
     * @throws RequestException|Exception If the request fails.
     */
    public function searchPosts($query)
    {
        try {



         return   $response = $this->setHttpResponse(getConfigSocial("app.facebook.user_search_post"), "GET", [], $query)->getResponse();
      
        } catch (Exception $e) {
            throw $e;
        }
    }
}
