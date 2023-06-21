<?php

require __DIR__.'/../vendor/autoload.php';

use ZerosDev\NobuBank\Client;

$mode = 'development';
$config = [
    'development' => [
        'login'         => '',
        'password'      => '',
        'merchant_id'   => '',
        'store_id'      => '',
        'pos_id'        => '',
        'secret_key'    => '',
    ],
    'production' => [
        'login'         => '',
        'password'      => '',
        'merchant_id'   => '',
        'store_id'      => '',
        'pos_id'        => '',
        'secret_key'    => '',
    ]
];

$nobu = new Client($mode, $config[$mode]);

$qris = $nobu->qris()
    /**
     * Set transaction number
     *
     * @param string $transaction_no
     */
    ->setTransactionNo('LOCALTEST001')

    /**
     * Set reference number
     *
     * @param string $reference_no
     */
    ->setReferenceNo('100LOCALTEST')

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
     * Set Store ID / MPAN (Defaults to config di ENV if not specified)
     *
     * @param string $store_id
     */
    ->setStoreId('ID2023123456789')

    /**
     * Set Store ID / NMID (Defaults to config di ENV if not specified)
     *
     * @param string $merchant_id
     */
    ->setMerchantId('930000000000000000')

    /**
     * Execute action
     */
    ->createDynamicWithoutTip();

// echo $qris;

/**
 * For debugging purpose
 */
print_r($nobu->debugs());
