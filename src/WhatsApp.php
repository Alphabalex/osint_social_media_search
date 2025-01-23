<?php

namespace Eaglewatch\Search;

use Eaglewatch\Search\Abstracts\HttpRequest;
use Exception;

class WhatsApp extends HttpRequest
{

  public function  __construct()
  {
    $this->setApiUrl(config('app.whatsApp.api_url'));
    $this->additionalHeader = [
      'x-rapidapi-host' => config('app.whatsApp.x-rapidapi-host', ''),
      'x-rapidapi-key'  => config('app.whatsApp.x-rapidapi-key')
    ];
    $this->setRequestOptions();
  }



  /**
   * Retrieves the user profile for a given phone number.
   *
   * to fetch the associated user profile.
   *
   *******/
  public function getUserProfileByNumber($number)
  {
    $url = config('app.WhatsApp.user_profile_endpoint') . $number;
    try {
      return $this->setHttpResponse($url, 'GET', [])->getResponse();
    } catch (Exception $e) {
      throw new Exception("Error Processing Request" . $e->getMessage());
    }
  }



  /**
   * Downloads the profile picture for a given phone number.
   *
   * Sends a GET request to retrieve the profile picture associated with the specified phone number.
   *
   * @param string $number The phone number whose profile picture you want to download.
   * @param string $savePath The file path where the image will be saved.
   * @return bool Returns true if the profile picture was successfully downloaded, false otherwise.
   */
  public function downloadProfilePicture($number)
  {
    $url = config('app.whatsApp.user_profile_picture_endpoint') . $number;
    try {
      return $this->setHttpResponse($url, 'GET', [])->getResponse();
    } catch (Exception $e) {
      throw new Exception("Error Processing Request" . $e->getMessage());
    }
  }
}
