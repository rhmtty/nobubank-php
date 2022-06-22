<?php

require __DIR__.'/../vendor/autoload.php';

use ZerosDev\NobuBank\Client;

$mode = 'development';
$config = [
    'base_url'      => 'http://uatmerchant.nobubank.com:2104/',
    'login'         => '',
    'password'      => '',
    'merchant_id'   => '',
    'store_id'      => '',
    'secret_key'    => '',
];

$nobu = new Client($mode, $config);

$qris = $nobu->qris()
    /**
     * Set transaction number
     * 
     * @param string $transactionNo
     */
    ->setTransactionNo('ABCDEFGHIJKLMNO')

    /**
     * Set reference number
     * 
     * @param string $referenceNo
     */
    ->setReferenceNo('1234567890')

    /**
     * Set payment amount
     * 
     * @param int $amount
     */
    ->setAmount(1000)

    /**
     * Set QR validity time in seconds
     * 
     * @param int $validTime
     */
    ->setValidTime(3600)

    /**
     * Set displayed store name
     * 
     * @param string $storeName
     */
    ->setStoreName('Zeros Technology')

    /**
     * Set displayed city name
     * 
     * @param string $cityName
     */
    ->setCityName('Ponorogo')

    /**
     * Execute action
     */
    ->createDynamic();

echo $qris;

/**
 * For debugging purpose
 */
// print_r($nobu->debugs());