<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class Tictok extends HttpRequest
{

    public function __construct(?string  $api_key = null )
    {
        $this->setApiUrl(getConfigSocial('app.tictok.domain_url'));
        $this->additionalHeader = ['x-rapidapi-host' => getConfigSocial('app.tictok.x-rapidapi-host'), 'x-rapidapi-key' => $api_key ? $api_key : getConfigSocial("tictok.x-rapidapi-key")];
        $this->setRequestOptions();
    }



    public function userNameSearch(string $search)
    {
        try {
            return $this->setHttpResponse("user/info?uniqueId={$search}", 'GET', [])->getResponse();
        } catch (Exception $e) {
            throw $e;
        }
    }
    

    /**
     * 
     * @param array $query = [
     *  keyword => "cat" , "cursor(optional)" => "", "search_id(optional)" => 
     * ]
     * 
     *     
     */

    public function generalSearch(array $query)
    {
        try {
            return $this->setHttpResponse("search/general", 'GET', [], $query)->getResponse();
        } catch (Exception $e) {
            throw $e;
        }
    }
}
