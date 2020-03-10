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
     * @return \Illuminate\Http\Response
     */
    protected function sendResponse($result, $message = '', $code = 200)
    {
        $response = [
            'success' => true,
            'data' => json_decode((string)$result),
            'message' => $message,
        ];


        return response()->json($response, $code);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['errors'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
