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
     * Set refund amount
     *
     * @param int $amount
     */
    ->setAmount(1000)

    /**
     * Set payment transaction reference unique number that needs to be refund.
     *
     * @param int $payment_reference_no
     */
    ->setPaymentReferenceNo('2022060601010101')

    /**
     * Set issuer’s id used by customer to pay the transaction.
     *
     * @param string $issuer_id
     */
    ->setIssuerId('Zeros Technology')

    /**
     * Set retrieval reference unique number for a specific payment transaction.
     *
     * @param string $retrieval_reference_no
     */
    ->setRetrievalReferenceNo('2022060601010101')

    /**
     * Execute action
     */
    ->refund();

echo $qris;

/**
 * For debugging purpose
 */
// print_r($nobu->debugs());
