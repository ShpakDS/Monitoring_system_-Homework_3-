<?php

class ExchangeRateApi
{
    public function getRate(string $currency): ?float
    {
        $url = sprintf('%s?json&valcode=%s', 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange', $currency);

        try {
            $response = file_get_contents($url);
            if ($response === false) {
                throw new Exception('Failed to fetch response data');
            }

            $data = json_decode($response, true);
            return $data[0]['rate'] ?? null;
        } catch (Exception $e) {
            error_log('Error fetching exchange rate: ' . $e->getMessage());
            return null;
        }
    }
}