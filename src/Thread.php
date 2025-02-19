<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class Thread extends HttpRequest
{

    private $USER_DETAILS_WITH_BIO = "users/detail-with-biolink";

    private $USER_POST_BY_USERNAME = "users/posts";

    private $SEARCH_USER = "users/search";

    private $USER_DETAIL ="users/detail";

    private $POST_SEARCH = "posts/search";

   


    public function __construct(?string $api_key = null  )
    {
        $this->setApiUrl(config('app.thread.domain_url'));
        $this->additionalHeader = ['x-rapidapi-host' => config('app.thread.x-rapidapi-host'), 'x-rapidapi-key' => $api_key ? $api_key :   config('app.thread.x-rapidapi-key')  ];
        $this->setRequestOptions();
    }

    /**
     * @param string username
     * @return mixed 
     * 
     */
    public function userDetailsSearch(string $username)
    {
        try {
            $query = ["username"=> $username];

            return $this->setHttpResponse($this->USER_DETAIL, 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }


    /**
     * @param string userName
     * @return mixed
     * search all the users associated with that name
     */
    public function userNameSearch(string $username)
    {
        try {

            $query = ["query"=> $username];

            return $this->setHttpResponse($this->SEARCH_USER, 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }


      /**
     * @param string userName
     * @return mixed
     * search all the users associated with that name
     */
    public function postsSearch(string $query)
    {
        try {

            $query = ["query"=> $query];

            return $this->setHttpResponse($this->POST_SEARCH, 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }

    /**
     * @param string userName
     * @return mixed
     * search a post related to a particular user
     * 
     */
    public function userPostSearch(string $userName)
    {
        try {
            $query = ["username"=> $userName];

            return $this->setHttpResponse($this->USER_POST_BY_USERNAME, 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }


    /**
     * @param string userName
     * @return mixed
     * search for a user and return thier bio link
     * 
     */
    public function userDetailsWithBioLink(string $userName)
    {
        try {

          $query = ["username"=> $userName];

            return $this->setHttpResponse($this->USER_DETAILS_WITH_BIO, 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }
}
