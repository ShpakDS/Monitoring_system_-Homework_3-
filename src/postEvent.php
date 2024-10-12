<?php

require_once 'ExchangeRateApi.php';
require_once 'GoogleAnalytics.php';

class ExchangeRateUpdater
{
    private $measurementId;
    private $apiSecret;
    private ExchangeRateApi $exchangeRateApi;
    private GoogleAnalytics $googleAnalytics;

    public function __construct($measurementId, $apiSecret)
    {
        $this->measurementId = $measurementId;
        $this->apiSecret = $apiSecret;
        $this->exchangeRateApi = new ExchangeRateApi();
        $this->googleAnalytics = new GoogleAnalytics($measurementId, $apiSecret);
    }

    public function updateExchangeRate($currencyPair)
    {
        $rate = $this->exchangeRateApi->getRate($currencyPair);

        if ($rate) {
            $this->googleAnalytics->sendEvent('exchange_rate_update', [
                'currency_pair' => $currencyPair,
                'exchange_rate' => $rate,
            ]);
            echo "Exchange rate sent to Google Analytics successfully.\n";
        } else {
            echo "Failed to retrieve the exchange rate.\n";
        }
    }
}

$measurementId = getenv('GA4_MEASUREMENT_ID');
$apiSecret = getenv('GA4_API_SECRET');

$exchangeRateUpdater = new ExchangeRateUpdater($measurementId, $apiSecret);
$exchangeRateUpdater->updateExchangeRate('USD');