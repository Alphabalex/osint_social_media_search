<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class Twitter extends HttpRequest
{
     private $SEARCH_URI = "/search.php";

     private $SEARCH_BY_SCREENNAME = "/screenname.php";


     private $SEARCH_USER_TIMELINE = "/timeline.php";


    public function __construct(?string $api_key = null )
    {
        $this->setApiUrl(config('app.twitter.api_url', "https://twitter-api45.p.rapidapi.com"));
        $this->additionalHeader = ['x-rapidapi-host' => config('app.twitter.x-rapidapi-host'), 
        'x-rapidapi-key' => $api_key ? $api_key : config('app.twitter.x-rapidapi-key') ];
        $this->setRequestOptions();
    }

    /**
     * @param array $query
     *  
     * $query = [ query= 
     *            cursor(optional)=
     *            search_type(optional)=] 
     * 
     *  search_type value in (Top, Latest,Media, People, Lists, )
     * 
     * @return array 
     */
    public function generalSearch($query){


          try{
            
            $response  =   $this->setHttpResponse($this->SEARCH_URI,"GET",
              [], $query);

          return $response->getResponse();
              

          }catch(Exception $e){

            throw new Exception("Errror communicating with {$this->baseUrl}{$this->SEARCH_URI}: " . $e->getMessage());

          }


    }
   
    /**
     * 
     * @param string $screenname
     */
    public function searchUSerByScreenName($screenname){
       try{
          $query = ["screenname" => $screenname];

          $response = $this->setHttpResponse($this->SEARCH_BY_SCREENNAME,"GET", [],
        $query);

         return $response->getResponse();

       }catch(Exception $e){
       
        throw new Exception("Errror communicating with {$this->baseUrl}{$this->SEARCH_BY_SCREENNAME}: " . $e->getMessage());
       }


    }


    /**
     * @param array $query
     * 
     * query contains ["screenname"=>
     *     "cursor"=>
     * ]
     * 
     * 
     */
    public function getUSerTimelineByUsername($query){
        

         try{
          

          $response = $this->setHttpResponse($this->SEARCH_USER_TIMELINE,"GET", [],
        $query);

         return $response->getResponse();

       }catch(Exception $e){
       
        throw new Exception("Errror communicating with {$this->baseUrl}{$this->SEARCH_BY_SCREENNAME}: " . $e->getMessage());
       }



    }






    /**
     * return the user with the username
     * @param string $username
     * @return array|mixed
     */
    // public function search($username)
    // {
    //     try {
    //         return $this->setHttpResponse("?username={$username}", 'GET', [])->getResponse();
    //     } catch (Exception $e) {
    //         throw new Exception("Error Processing Request" . $e->getMessage());
    //     }
    // }
}
