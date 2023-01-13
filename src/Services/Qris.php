<?php

namespace ZerosDev\NobuBank\Services;

use ZerosDev\NobuBank\Client;
use ZerosDev\NobuBank\Constant;
use ZerosDev\NobuBank\Traits\SetterGetter;

class Qris
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
            'validTime' => (int) $this->getValidTime(3600), // in seconds
            'storeName' => (string) $this->getStoreName(),
            'cityName' => (string) $this->getCityName(),
        ];

        $content['signature'] = md5(implode('', array_values($content)) . $config['secret_key']);

        $this->client->setRequestRawPayload($content);

        $payload = [
            'data'  => base64_encode(json_encode($content)),
        ];

        $this->client->setRequestPayload($payload);

        return $this->client->request('generalNew/Partner/GetQRISCustomName', 'POST', Constant::CONTENT_JSON);
    }

    public function createDynamicWithoutTip()
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

        $content['signature'] = md5(implode('', array_values($content)) . $config['secret_key']);

        $this->client->setRequestRawPayload($content);

        $payload = [
            'data'  => base64_encode(json_encode($content)),
        ];

        $this->client->setRequestPayload($payload);

        return $this->client->request('generalNew/Partner/GetQRISCustomNameWithoutTip', 'POST', Constant::CONTENT_JSON);
    }

    public function paymentStatus()
    {
        $config = $this->client->getConfig();

        $content = [
            'login' => (string) $config['login'],
            'password' => (string) $config['password'],
            'merchantID' => (string) $config['merchant_id'],
            'storeID' => (string) $config['store_id'],
            'posID' => (string) $this->getPosId('A01'),
            'transactionNo' => (string) $this->getTransactionNo()
        ];

        $content['signature'] = md5(implode('', array_values($content)) . $config['secret_key']);

        $this->client->setRequestRawPayload($content);

        $payload = [
            'data' => base64_encode(json_encode($content)),
        ];

        $this->client->setUseBaseUrl('status');
        $this->client->setRequestPayload($payload);

        return $this->client->request('api/Partner/InquiryPayment', 'POST', Constant::CONTENT_JSON);
    }

    public function refund()
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
            'amount' => (string) $this->getAmount(),
            'paymentReferenceNo' => (string) $this->getPaymentReferenceNo(),
            'issuerID' => (string) $this->getIssuerId(),
            'retrievalReferenceNo' => (string) $this->getRetrievalReferenceNo(),
        ];

        $content['signature'] = md5(implode('', array_values($content)) . $config['secret_key']);

        $this->client->setRequestRawPayload($content);

        $payload = [
            'data' => base64_encode(json_encode($content)),
        ];

        $this->client->setRequestPayload($payload);

        return $this->client->request('generalNew/Partner/RequestRefundQRIS', 'POST', Constant::CONTENT_JSON);
    }

    public function cancel()
    {
        $config = $this->client->getConfig();

        $content = [
            'login' => (string) $config['login'],
            'password' => (string) $config['password'],
            'merchantID' => (string) $config['merchant_id'],
            'storeID' => (string) $config['store_id'],
            'transactionNo' => (string) $this->getTransactionNo(),
            'referenceNo' => (string) $this->getReferenceNo(),
            'amount' => (string) $this->getAmount(),
            'qrisData' => (string) $this->getQrisData(),
        ];

        $content['signature'] = md5(implode('', array_values($content)) . $config['secret_key']);

        $this->client->setRequestRawPayload($content);

        $payload = [
            'data' => base64_encode(json_encode($content)),
        ];

        $this->client->setUseBaseUrl('cancel');
        $this->client->setRequestPayload($payload);

        return $this->client->request('general/Partner/CancelQRIS', 'POST', Constant::CONTENT_JSON);
    }

    public function getIssuerNameById($issuerId)
    {
        $issuers = [
          '93600002' => 'BRI',
          '93600009' => 'BNI',
          '93600008' => 'Mandiri Pay',
          '93600011' => 'Danamon',
          '93600013' => 'Permata',
          '93600014' => 'BCA',
          '93600016' => 'Maybank',
          '93600022' => 'Niaga',
          '93600111' => 'DKI',
          '93600153' => 'Sinarmas',
          '93600426' => 'Mega',
          '93600503' => 'Nobu',
          '93600898' => 'T-Money',
          '93600911' => 'LinkAja',
          '93600912' => 'OVO',
          '93600914' => 'Go-Pay',
          '93600915' => 'Dana',
          '93600917' => 'Paytrend',
          '93600999' => 'AHDI',
          '93600918' => 'ShopeePay',
          '93600129' => 'BPD Bali',
          '93600451' => 'Syariah Indonesia',
          '93600118' => 'Nagari',
          '93600110' => 'BJB',
          '93600811' => 'OTTOCASH',
          '93600114' => 'BPD-JATIM',
          '93600919' => 'BluePay',
          '93600028' => 'OCBC',
          '93600815' => 'Bimasakti Multi Sinergi',
          '93600130' => 'BPD NTT',
          '93600899' => 'Doku',
          '93600023' => 'Bank UOB Indonesia',
          '93600816' => 'SPIN',
          '93600120' => 'Bank Sumselbabel',
          '93600422' => 'BRIS Pay',
          '93600484' => 'Hana bank',
          '93600213' => 'Jenius',
          '1234567' => 'test',
          '93600812' => 'Kaspro',
          '93600126' => 'Bank Sulsel',
          '93600920' => 'Isaku',
          '93600814' => 'Netzme',
          '93600112' => 'BPD DIY',
          '93600777' => 'Finpay',
          '93600115' => 'Bank Pembangunan Daerah Jambi',
          '93600822' => 'Astrapay',
          '93600818' => 'Paydia',
          '93600147' => 'Muamalat',
          '93600523' => 'Bank Sahabat Sampoerna',
          '93600950' => 'Commonwealth',
          '93600817' => 'Yukk',
          '93600167' => 'QNB Indonesia',
          '93600200' => 'BTN',
          '93600037' => 'Bank Artha Graha Internasional',
          '93600813' => 'GAJA',
          '93600789' => 'IMkas',
          '93600501' => 'BCAD',
          '93600916' => 'Gudang Voucher',
          '93600553' => 'Bank Mayora',
          '93600076' => 'Bumi Arta ',
          '93608161' => 'POS Indonesia',
          '93600425' => 'BJB Syariah',
          '93600132' => 'Bank Papua',
          '93600536' => 'BCA Syariah',
          '93600116' => 'Bank Aceh Syariah',
          '93600548' => 'Bank Multiarta Sentosa',
          '93600119' => 'Bank Riau Kepri',
          '93600441' => 'Bank KB Bukopin',
          '93600128' => 'Bank NTB Syariah',
          '193600826' => 'Dipay',
          '93600161' => 'Bank Ganesha',
          '93600124' => 'Bank BPD Kalimantan Timur dan Kalimantan Utara',
          '93600123' => 'Bank Kalbar',
          '93600808' => 'Bayarind',
          '93600828' => 'TrueMoney',
          '193600823' => 'Paprika',
          '93600827' => 'Fello',
          '93600494' => 'Bank Raya',
          '93600046' => 'DBS MAX QRIS',
          '93600825' => 'Zipay',
          '93600820' => 'PAC Cash',
          '93600513' => 'Bank Ina Perdana',
          '93600567' => 'Allo Bank Indonesia',
          '93600490' => 'Bank Neo Commerce',
          '93600113' => 'Bank Jateng',
          '93600152' => 'Bank Shinhan',
          '93600121' => 'Bank Lampung',
          '93600921' => 'Saldomu',
          '93600485' => 'Motion Banking',
          '93600821' => 'Midazpay',
          '97640904' => 'Kasikornbank',
          '97640906' => 'Krung Thai Bank',
          '97640914' => 'Siam Commercial Bank',
          '97640925' => 'Bank of Ayudya',
          '97640922' => 'CIMB Thailand',
          '97640902' => 'Bangkok Bank',
          '94588639' => 'Razer Merchant Services Sdn Bhd',
          '94586225' => 'Public Bank Berhad',
          '93600019' => 'Bank Panin',
          '93600835' => 'Virgo',
          '93600998' => 'DSP',
          '93600122' => 'Bank Kalsel',
          '93600535' => 'Seabank',
          '93600157' => 'Bank Maspion',
          '93600531' => 'Amar'
        ];

        return isset($issuers[$issuerId]) ? $issuers[$issuerId] : null;
    }
}
