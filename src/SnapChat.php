<?php


namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class SnapChat extends HttpRequest
{

    public function __construct( ?string $api_key = null  )
    {
        $this->setApiUrl(getConfigSocial('app.snapchat.domain_url'));
        $this->additionalHeader = [
            'x-rapidapi-host' => getConfigSocial('app.snapchat.x-rapidapi-host', ''),
            'x-rapidapi-key' => $api_key ? $api_key : getConfigSocial('app.snapchat.x-rapidapi-key'),
        ];
        $this->setRequestOptions();
    }


    /**
     * @param string $username
     * @return mixed $response
     */
    public function searchUserProfile(string $username)
    {
        try {
            return $this->setHttpResponse("/getProfile?username={$username}", 'GET', [])->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }

    /**
     * @param string $username
     * @return mixed $response
     */
    public function searchUserLenses(string $username)
    {
        try {
            return $this->setHttpResponse("/getUserLenses?username={$username}", 'GET', [])->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }


    /**
     * @param string $username
     * @return mixed $response
     */
    public function searchUserStory(string $username)
    {
        try {
            return $this->setHttpResponse("/getUserStory?username={$username}", 'GET', [])->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }

    /**
     * @param string $username
     * @return mixed $response
     */
    public function searchUserSpotlightHighlights(string $username)
    {
        try {
            return $this->setHttpResponse("/getUserSpotlightHighlights?username={$username}", 'GET', [])->getResponse();
        } catch (Exception $e) {
            throw new Exception("Error Processing Request" . $e->getMessage());
        }
    }
}
