<?php

namespace Tschope\Finnhubio;

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;

class Stock extends Finnhubio
{
    public function profile(String $symbol = null, String $isin = null, String $cusip = null)
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['isin'] = $isin;
        $this->getParams['query']['cusip'] = $cusip;

        return $this->response('profile');
    }

    public function quote(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('quote');
    }

    private function response($uri)
    {
        try {
            $res = $this->httpClient->request('GET', $uri, $this->getParams);
            return $this->sendResponse($res->getBody());
        } catch (ClientException $e) {
            if ($e->getStatusCode() == 429) {
                return $this->sendError('You have exceeded your limit. Try again later.', [], 429);
            } else {
                return $this->sendError(Psr7\str($e->getResponse()), [],$e->getStatusCode());
            }
        }

    }
}
