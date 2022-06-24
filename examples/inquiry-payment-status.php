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
     * Execute action
     */
    ->paymentStatus();

echo $qris;

/**
 * For debugging purpose
 */
// print_r($nobu->debugs());
