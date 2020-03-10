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

    public function ceoCompensation(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('ceo-compensation');
    }

    public function executive(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('executive');
    }

    public function recommendation(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('recommendation');
    }

    public function priceTarget(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('price-target');
    }

    public function upgradeDowngrade(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('upgrade-downgrade');
    }

    public function optionChain(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('option-chain');
    }

    public function peers(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('peers');
    }

    public function earnings(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('earnings');
    }

    /**
     * @param String $symbol
     * @param string $metric price, valuation, growth, margin, management, financialStrength, perShare
     * @return \Illuminate\Http\Response
     *
        symbol
        Symbol of the company.

        metricType
        Metric type.

        metric
        Map key-value pair of metrics. Unit of metric type growth, and margin is (%). For other metric types, unit is reported currency which can be obtained with Company Profile
     */

    public function metrics(String $symbol, $metric = 'margin')
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['metric'] = $metric;

        return $this->response('metric');
    }

    public function investorOwnership(String $symbol, $limit = 20)
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['limit'] = $limit;

        return $this->response('investor-ownership');
    }

    public function fundOwnership(String $symbol, $limit = 20)
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['limit'] = $limit;

        return $this->response('fund-ownership');
    }

    public function financials(String $symbol, $statement = 'bs', $freq = 'annual')
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['statement'] = $statement;
        $this->getParams['query']['freq'] = $freq;

        return $this->response('financials');
    }

    public function exchange()
    {
        return $this->response('exchange');
    }

    public function symbol(String $exchange)
    {
        $this->getParams['query']['exchange'] = $exchange;

        return $this->response('symbol');
    }

    public function quote(String $symbol)
    {
        $this->getParams['query']['symbol'] = $symbol;

        return $this->response('quote');
    }

    public function candle(String $symbol, $resolution = '15', $from = null, $to = null, $adjusted = 'false', $count = '1')
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['resolution'] = $resolution;
        $this->getParams['query']['from'] = $from;
        $this->getParams['query']['to'] = $to;
        $this->getParams['query']['adjusted'] = $adjusted;
        $this->getParams['query']['count'] = $count;
        $this->getParams['query']['format'] = 'json';

        return $this->response('candle');
    }

    public function tick(String $symbol, $from = null, $to = null)
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['from'] = $from;
        $this->getParams['query']['to'] = $to;

        return $this->response('tick');
    }

    public function dividend(String $symbol, $from = null, $to = null)
    {
        $this->getParams['query']['symbol'] = $symbol;
        $this->getParams['query']['from'] = $from;
        $this->getParams['query']['to'] = $to;

        return $this->response('dividend');
    }

    public function split(String $symbol, $from = null, $to = null)
    {
        $this->getParams['query']['symbol'] = $symbol;

        if ($from == null) {
            $from = date('Y-m-d', strtotime('-7 days'));
        }

        if ($to == null) {
            $to = date('Y-m-d');
        }

        $this->getParams['query']['from'] = $from;
        $this->getParams['query']['to'] = $to;

        return $this->response('split');
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
