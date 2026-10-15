# Crypto-QR

*By [Reyesoft](http://reyesoft.com/)*

This library generates PNG QR codes for cryptocurrency addresses using [chillerlan/php-qrcode](https://github.com/chillerlan/php-qrcode).

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require reyesoft/crypto-qr
```

## Basic usage

```php
use CryptoQr\BitcoinQr;

$qr = new BitcoinQr('3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs');

header('Content-Type: image/png');
echo $qr->getString();
```

## Advanced usage

```php
use CryptoQr\BitcoinQr;

// Create a basic QR code
$qr = new BitcoinQr('3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs');
$qr->setSize(300);
$qr->setAmount(0.01);
$qr->setLabel('Caritas');
$qr->setMessage('Donation for project Maria');

// Directly output the QR code
header('Content-Type: image/png');
echo $qr->getString();

// Save it to a file
$qr->writeFile(__DIR__.'/qrcode.png');
```

![bitcoin qr](https://user-images.githubusercontent.com/938894/44047859-1c4b94b0-9f06-11e8-85d7-ea7d3728691c.png "Bitcoin QR generated with BitcoinQr library")


## Testing

```bash
composer test
sh autofix.sh
```

### PHP 8.4

```bash
docker run -it --rm --name php84 -e PHP_EXTENSIONS="gd" -v "$PWD":/usr/src/app thecodingmachine/php:8.4-v4-cli bash
```
