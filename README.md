# Crypto-QR

*By [Reyesoft](http://reyesoft.com/)*

This library helps you generate QR codes for Crypto Address. Makes use of [endroid/qr-code](https://github.com/endroid/qr-code). Further extended with Twig extensions, generation routes, a factory and a

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require reyesoft/crypto-qr
```

## Basic usage

```php
use Reyesoft\CryptoQr\BitcoinQr;

$qr = new BitcoinQr('3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs');

header('Content-Type: '.$qr->getQrCode()->getContentType());
echo $qr->getQrCode()->writeString();
```

## Advanced usage

```php
use Reyesoft\CryptoQr\BitcoinQr;

// Create a basic QR code
$qr = new BitcoinQr('3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs');
$qr->getQrCode()->setSize(300);
$qr->setAmount(0.01);
$qr->setLabel('Caritas');
$qr->setMessage('Donation for project Maria');

// Directly output the QR code
header('Content-Type: '.$qr->getQrCode()->getContentType());
echo $qr->getQrCode()->writeString();

// Save it to a file
$qr->getQrCode()->writeFile(__DIR__.'/qrcode.png');
```

`getQrCode()` return a instance of `Endroid\QrCode\QrCode`, then you have more options for your QR on
[endroid/qr-code](https://github.com/endroid/qr-code/blob/master/README.md#advanced-usage).


![bitcoin qr](https://user-images.githubusercontent.com/938894/44047859-1c4b94b0-9f06-11e8-85d7-ea7d3728691c.png "Bitcoin QR generated with BitcoinQr library")

