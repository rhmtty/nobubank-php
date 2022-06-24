<?php

require __DIR__.'/../vendor/autoload.php';

use ZerosDev\NobuBank\Client;

$mode = 'development';
$config = [
    'login'         => '',
    'password'      => '',
    'merchant_id'   => '',
    'store_id'      => '',
    'pos_id'        => '',
    'secret_key'    => '',
];

$nobu = new Client($mode, $config);

$qris = $nobu->qris()
    /**
     * Set transaction number
     *
     * @param string $transaction_no
     */
    ->setTransactionNo('ABCDEFGHIJKLMNO')

    /**
     * Set reference number
     *
     * @param string $reference_no
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
     * @param int $valid_time
     */
    ->setValidTime(3600)

    /**
     * Set displayed store name
     *
     * @param string $store_name
     */
    ->setStoreName('Zeros Technology')

    /**
     * Set displayed city name
     *
     * @param string $city_name
     */
    ->setCityName('Ponorogo')

    /**
     * Execute action
     */
    ->createDynamicWithoutTip();

echo $qris;

/**
 * For debugging purpose
 */
// print_r($nobu->debugs());
