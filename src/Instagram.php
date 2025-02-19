<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;
use GuzzleHttp\Exception\RequestException;

class Instagram extends HttpRequest
{
    /**
     * Initializes the Instagram class with API configuration.
     *
     * Sets the API URL using the domain URL from the Instagram configuration and
     * initializes additional headers.
     */
    public function __construct(?string $api_key =  null )
    {
        $this->setApiUrl(getConfigSocial('app.instagram.api_url'));
        $this->additionalHeader = [
            'x-rapidapi-host' => getConfigSocial('app.instagram.x-rapidapi-host', ''),
            'x-rapidapi-key' => $api_key ? $api_key : getConfigSocial('app.instagram.x-rapidapi-key'),
        ];

        $this->setRequestOptions();
    }

    /**
     * Search for a user by username
     *
     * @param string $username The username to search for
     *
     * @return array|null The response from the API, or null if the request fails
     *
     * @throws RequestException|Exception If the request fails
     */
    public function getUserByUsername($username)
    {


        try {
            $result = $this->setHttpResponse(getConfigSocial('app.instagram.user_info_endpoint'), 'POST', ["username" => $username])->getResponse();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }

    /**
     * Search for user by query
     *
     * @param string $query The search query
     *
     * @return array|null The response from the API, or null if the request fails
     */
    public function searchUserByQuery($query)
    {
        try {
            $result = $this->setHttpResponse(getConfigSocial("app.instagram.user_search_endpoint"), 'POST', ["query" => $query])->getResponse();
            return $result;
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }
}
