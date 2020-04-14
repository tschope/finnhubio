<?php
namespace Tschope\Finnhubio;

use \GuzzleHttp\Client;

class Finnhubio
{
    protected $apiUrl = 'https://finnhub.io/api/v1/';

    protected $token = null;

    protected $httpClient = null;

    protected $getParams = [];

    public function __construct()
    {
        // Create a client with a base URI
        $this->httpClient = new Client(['base_uri' => $this->apiUrl]);
        $this->token = config('finnhubio.token');

        $this->getParams['query'] = ['token' => $this->token];
    }

    /**
     * success response method.
     *
     * @return object
     */
    protected function sendResponse($result, $message = '')
    {
        $response = [
            'success' => true,
            'data' => json_decode((string)$result),
            'message' => $message,
        ];

        return (object)$response;
    }


    /**
     * return error response.
     *
     * @return object
     */
    protected function sendError($error, $errorMessages = [])
    {
        $response = [
            'success' => false,
            'data' => null,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }

        return (object)$response;
    }
}
