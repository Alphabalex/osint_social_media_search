<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class LinkedIn extends HttpRequest
{

    private  $SEARCH_PEOPLE = "/search-people";

    private $SEARCH_PROFILE_POSTS_BY_USERNAME = "/get-profile-posts";

    private $VERICATION_DATA = "/about-this-profile";


    public function __construct(?string  $api_key = null )
    {
        $this->setApiUrl(getConfigSocial('app.snapchat.domain_url'));
        $this->additionalHeader = [
            'x-rapidapi-host' => getConfigSocial('app.linkedin.x-rapidapi-host', ''),
            'x-rapidapi-key' => $api_key ? $api_key : getConfigSocial('app.linkedin.x-rapidapi-key'),
        ];
        $this->setRequestOptions();
    }

    /**
     * @param mixed $params = $linkedIn =  ["firstname"=>"", "lastname" =>"", "geo"=>"" , "company" => '', "keywordSchool" => '', "keywords" => '',
     * "start"=>"", "schoolId"=>"", "keywordSchool"=>"", "keywordTitle"=>"", "company"=>"" ]
     * @return mixed $response
     */
    public function searchUsers($params = [])
    {
        try {

           return $this->setHttpResponse($this->SEARCH_PEOPLE, 'GET', [], $params)->getResponse();

        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * @param string $username
     * @param string poatedAt (2024-01-01 00:00)
     * @param string $start -> use this param to get posts in next results page: 0 for page 1, 50 for page 2 100 for page 3, etc
     * @param $query contains keys like [ username, start paginationToken postedAt ]
     */
    public function searchProfilePostByUsername($query)
    {
        try {
            return $this->setHttpResponse($this->SEARCH_PROFILE_POSTS_BY_USERNAME, 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * @param string $username
     * @return mixed
     */
    public function searchUserProfileByUsername($username)
    {
        try {
              $this->setHttpResponse("/?username={$username}", 'GET', []);
            
             $data = $this->response->getBody();
         
             $data = json_decode($data, true);

             $verificationData = $this->searchUserVerificationDataByUsername($username);

             if(isset($data)){

              $data["verificationData"] = $verificationData;

             } 

             return $data;
             

        } catch (Exception $e) {
            throw $e;
        }
    }


    /**
     * @param string $username
     * @return mixed
     * 
     * This endpoint provides information that needs to come with the profile information 
     * so included  in searchUserByProfile implementation
     */
    private function searchUserVerificationDataByUsername($username)
    {
        try {

           $query = ["username" => $username];

           $object =  $this->setHttpResponse($this->VERICATION_DATA, 'GET', [], $query);
           $data = json_decode($object->response->getBody(), true);
           $validationData = null;

           if (isset($data['data'])) {

            $validationData = $data['data'];
           }
          

           return $validationData;


        } catch (Exception $e) {

            throw $e;
        }
    }
}
