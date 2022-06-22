<h1 align="center">nobubank-php</h1>
<h6 align="center"></h6>

<p align="center">
  <img src="https://img.shields.io/github/v/release/zerosdev/nobubank-php?include_prereleases" alt="release"/>
  <img src="https://img.shields.io/github/languages/top/zerosdev/nobubank-php" alt="language"/>
  <img src="https://img.shields.io/github/license/zerosdev/nobubank-php" alt="license"/>
  <img src="https://img.shields.io/github/languages/code-size/zerosdev/nobubank-php" alt="size"/>
  <img src="https://img.shields.io/github/downloads/zerosdev/nobubank-php/total" alt="downloads"/>
  <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="pulls"/>
</p>

## About

This library give you an easy way to call Nobu Bank API in elegant code style. Example :

```php
NobuBank::qris()
    ->setTransactionNo('ABCDEFGHIJKLMN')
    ->setReferenceNo('1234567890')
    ->setAmount(1000)
    ->setValidTime(3600)
    ->setStoreName('Nama Merchant')
    ->setCityName('Ponorogo')
    ->createDynamic();
```

## Installation

1. Run command
<pre><code>composer require zerosdev/nobubank-php</code></pre>

### The following steps only needed if you are using Laravel

2. Then
<pre><code>php artisan vendor:publish --provider="ZerosDev\NobuBank\Laravel\ServiceProvider"</code></pre>

3. Edit **config/nobu_bank.php** and put your API credentials

## Usage

### Laravel

```php
<?php

namespace App\Http\Controllers;

use NobuBank;

class YourController extends Controller
{
    public function index()
    {
        $dynamicQris = NobuBank::qris()
            ->setTransactionNo('ABCDEFGHIJKLMN')
            ->setReferenceNo('1234567890')
            ->setAmount(1000)
            ->setValidTime(3600)
            ->setStoreName('Nama Merchant')
            ->setCityName('Ponorogo')
            ->createDynamic();
            
        dd($dynamicQris);
    }
}
```

### Non-Laravel

```php
<?php

require 'path/to/your/vendor/autoload.php';

use ZerosDev\NobuBank\Client as NobuClient;

$mode = 'development';
$config = [
    'base_url'      => 'http://uatmerchant.nobubank.com:2104/',
    'login'         => '',
    'password'      => '',
    'merchant_id'   => '',
    'store_id'      => '',
    'secret_key'    => '',
];

$nobu = new NobuClient($mode, $config);

$dynamicQris = $nobu->qris()
    ->setTransactionNo('ABCDEFGHIJKLMN')
    ->setReferenceNo('1234567890')
    ->setAmount(1000)
    ->setValidTime(3600)
    ->setStoreName('Nama Merchant')
    ->setCityName('Ponorogo')
    ->createDynamic();
    
print_r($dynamicQris);
```
