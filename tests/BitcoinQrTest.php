<?php
/**
 * Created by PhpStorm.
 * User: juan
 * Date: 03/08/18
 * Time: 09:54
 */

namespace CryptoQr\Tests;

use PHPUnit\Framework\TestCase;
use CryptoQr\BitcoinQr;
use Zxing\QrReader;

class BitcoinQrTest extends TestCase
{
    public function testBitcoinQrAddress(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $qr = new BitcoinQr($address);
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address, $reader->text());
    }

    public function testBitcoinQrWithName(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $qr = new BitcoinQr($address);
        $qr->uriWithName('Jagannath');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?label=' . $qr->getName(), $reader->text());
    }

    public function testBitcoinQrWithRequestBtc(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $qr = new BitcoinQr($address);
        $qr->uriWithAmount(20.3, 'BTC');
        $qr->uriWithName('Jagannath');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=' . $qr->getAmount() . 'X8' .
                                    '&label=' . $qr->getName(), $reader->text());
    }

    public function testBitcoinQrWithRequestTbc(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $qr = new BitcoinQr($address);
        $qr->uriWithAmount(400, 'TBC');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=x' . $qr->getAmount() . 'X4', $reader->text());
    }

    public function testBitcoinQrWithRequestTbc4(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $qr = new BitcoinQr($address);
        $qr->uriWithAmount(4000, 'TBC');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=x' . $qr->getAmount() . 'X7', $reader->text());
    }

    public function testBitcoinQrWithRequest_uBtc(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $qr = new BitcoinQr($address);
        $qr->uriWithAmount(5, 'uBTC');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=' . $qr->getAmount() . 'X2', $reader->text());
    }

    public function testBitcoinQrWithRequestAndMessage(): void
    {
        $address = '3PrCdjyjcDHDSC8tvVgx1u96tMK9juncHs';
        $message = ('Donation for project xyz');
        $qr = new BitcoinQr($address);
        $qr->uriWithAmount(80, 'BTC');
        $qr->uriWithMessage($message);
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=' . $qr->getAmount() . 'X8' .
                                    '&message=' . rawurldecode($qr->getMessage()), $reader->text());
    }

    public function testWriteBitcoinQrFile(): void
    {
        $filename = __DIR__ . '/output/bitcoin-qr-code.png';

        $address = '175tWpb8K1S7NmH4Zx6rewF9WQrcZv245W';
        $name = 'Jagannath';
        $message = ('Donation for project xyz');
        $qr = new BitcoinQr($address);
        $qr->uriWithAmount(80, 'BTC');
        $qr->uriWithName($name);
        $qr->uriWithMessage($message);
        $qr->setSize(300);
        $qr->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertTrue(is_resource($image));
    }
}
