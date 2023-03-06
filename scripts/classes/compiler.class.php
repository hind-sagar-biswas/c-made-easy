<?php

class Compiler
{
    private $url = 'https://api.jdoodle.com/v1/execute';
    private $clientId = '';
    private $clientSecret = '';
    private $dailyLimit = 200;
    private $language = 'c';
    private $data = array('versionIndex' => '0',);

    private $http = array(
        'method' => 'POST',
        'header' => 'Content-Type: application/json',
    );

    public function __construct(string $language = 'c')
    {
        $this->data['clientId'] = $this->clientId;
        $this->data['clientSecret'] = $this->clientSecret;
        $this->data['language'] = $language;
    }


    public function execute(string $script)
    {
        $this->data['script'] = $script;
        $this->http['content'] = json_encode($this->data);

        $options = array(
            'http' => $this->http
        );

        $context = stream_context_create($options);
        $result = file_get_contents($this->url, false, $context);
        $response = json_decode($result, true);
        return $response;
    }

    public function getDailyHits()
    {
        $url = 'https://api.jdoodle.com/v1/credit-spent';
        $data = array(
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $response = json_decode($result, true);
        if (isset($response['used'])) {
            $response['limit'] = $this->dailyLimit;
            $response['remaining'] = $this->dailyLimit - $response['used'];
            return $response;
        } else {
            return -1; // error occurred
        }
    }

}
