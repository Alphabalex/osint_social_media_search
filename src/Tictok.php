<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class Tictok extends HttpRequest
{

    public function __construct()
    {
        $this->setApiUrl(getConfig('app.tictok.domain_url'));
        $this->additionalHeader = ['x-rapidapi-host' => getConfig('app.tictok.x-rapidapi-host'), 'x-rapidapi-key' => getConfig('app.tictok.x-rapidapi-key')];
        $this->setRequestOptions();
    }



    public function userNameSearch(string $search)
    {
        try {
            return $this->setHttpResponse("info?uniqueId={$search}", 'GET', [])->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }
}
