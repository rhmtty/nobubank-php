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
     * Set QR national dynamic data.
     *
     * @param string $qris_data
     */
    ->setQrisData('xxxxxxxxxxxxxxx')

    /**
     * Execute action
     */
    ->cancel();

echo $qris;

/**
 * For debugging purpose
 */
// print_r($nobu->debugs());
