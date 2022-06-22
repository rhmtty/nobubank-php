<?php

namespace ZerosDev\NobuBank\Services;

use ZerosDev\NobuBank\Client;
use ZerosDev\NobuBank\Constant;
use ZerosDev\NobuBank\Traits\SetterGetter;

class QRIS
{
    use SetterGetter;

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function createDynamic()
    {
        $config = $this->client->getConfig();

        $content = [
            'login' => (string) $config['login'],
            'password' => (string) $config['password'],
            'merchantID' => (string) $config['merchant_id'],
            'storeID' => (string) $config['store_id'],
            'posID' => (string) $this->getPosId("A01"),
            'transactionNo' => (string) $this->getTransactionNo(),
            'referenceNo' => (string) $this->getReferenceNo(),
            'amount' => (int) $this->getAmount(),
            'validTime' => (int) $this->getValidTime(3600), // seconds
            'storeName' => (string) $this->getStoreName(),
            'cityName' => (string) $this->getCityName(),
        ];

        $content['signature'] = md5(implode('', $content).$config['secret_key']);

        $payload = [
            'data'  => base64_encode(json_encode($content)),
        ];

        $this->client->setRequestPayload($payload);

        return $this->client->request('generalNew/Partner/GetQRISCustomName', 'POST', Constant::CONTENT_JSON);
    }
}