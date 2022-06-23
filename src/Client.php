<?php

namespace ZerosDev\NobuBank;

use Exception;
use GuzzleHttp\TransferStats;
use GuzzleHttp\Client as GuzzleClient;
use ZerosDev\NobuBank\Traits\SetterGetter;

class Client
{
    use SetterGetter;

    protected $http;
    protected $config = [];
    protected $mode;
    protected $request_endpoint;
    protected $request_url;
    protected $request_method;
    protected $request_payload = [];
    protected $request_raw_payload = [];
    protected $request_headers = [];
    protected $response;

    public function __construct(string $mode = 'development', array $config)
    {
        $this->init($mode, $config);
    }

    public function instance()
    {
        return $this;
    }

    public function useCredential(string $mode = 'development', array $config)
    {
        $this->init($mode, $config);

        return $this;
    }

    public function init(string $mode = 'development', array $config)
    {
        $this->setConfig($config);
        $this->setMode($mode);

        $this->setRequestHeaders([
            'Accept' => 'application/json'
        ]);

        $self = $this;
        $configs = [
            'base_uri'		=> ($mode === 'production') ? Constant::URL_API_PRODUCTION : Constant::URL_API_DEVELOPMENT,
            'http_errors' 	=> false,
            'headers'		=> $this->getRequestHeaders(),
            'on_stats' => function (TransferStats $s) use (&$self) {
                $self->setRequestUrl(strval($s->getEffectiveUri()));
            }
        ];

        if (isset($config['action']) && $config['action'] === 'status') {
            $configs['base_uri'] = $mode === 'production' ? Constant::URL_STATUS_PRODUCTION : Constant::URL_STATUS_DEVELOPMENT;
        }

        $this->http = new GuzzleClient($configs);
    }

    public function request($endpoint, $method = 'GET', $content_type = Constant::CONTENT_JSON)
    {
        $method = strtolower($method);

        $this->setRequestEndpoint($endpoint);
        $this->setRequestMethod(strtoupper($method));

        $options = [];

        switch ($this->getRequestMethod()) {
            case "POST":
                $this->addRequestHeaders('Content-Type', $content_type);
                switch ($content_type) {
                    case Constant::CONTENT_JSON:
                        $options['json'] = $this->getRequestPayload();
                        break;
                    case Constant::CONTENT_FORM:
                        $options['form_params'] = $this->getRequestPayload();
                        break;
                }
                break;
        }

        try {
            $response = $this->http->{$method}($endpoint, $options)
                ->getBody()
                ->getContents();
        } catch (Exception $e) {
            $response = $e->getMessage();
        }

        $d = json_decode($response);

        if (json_last_error() === JSON_ERROR_NONE) {
            $response = base64_decode($d->data);
        }

        $this->setResponse($response);

        return $this->getResponse();
    }

    public function debugs()
    {
        return [
            'mode' => $this->getMode(),
            'config' => $this->getConfig(),
            'url'	=> $this->getRequestUrl(),
            'method' => $this->getRequestMethod(),
            'raw_payload' => $this->getRequestRawPayload(),
            'payload' => $this->getRequestPayload(),
            'headers' => $this->getRequestHeaders(),
            'response' => $this->getResponse(),
        ];
    }
}
