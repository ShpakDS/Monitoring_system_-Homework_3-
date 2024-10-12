<?php

class GoogleAnalytics
{
    public function __construct(private readonly string $measurementId, private readonly string $apiSecret)
    {
        //
    }

    public function sendEvent(string $eventName, array $eventParams): void
    {
        $url = sprintf('%s?measurement_id=%s&api_secret=%s', 'https://www.google-analytics.com/mp/collect', $this->measurementId, $this->apiSecret);

        echo $this->apiSecret;

        $eventData = [
            'client_id' => 764,
            'events' => [
                [
                    'name' => $eventName,
                    'params' => $eventParams
                ]
            ]
        ];

        $options = [
            'http' => [
                'header' => "Content-Type: application/json\r\n",
                'method' => 'POST',
                'content' => json_encode($eventData),
            ],
        ];

        try {
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
//            var_dump($options);

            if ($result === false) {
                throw new Exception('Failed to send data to Google Analytics.');
            }
        } catch (Exception $e) {
            error_log('Error: ' . $e->getMessage());
        }
    }
}