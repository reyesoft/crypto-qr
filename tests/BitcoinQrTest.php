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
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $qr = new BitcoinQr($address);
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address, $reader->text());
    }

    public function testBitcoinQrWithName(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $qr = new BitcoinQr($address);
        $qr->setName('Jagannath');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?label=' . $qr->getName(), $reader->text());
    }

    public function testBitcoinQrWithRequestBtc(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $qr = new BitcoinQr($address);
        $qr->setAmount(20.3);
        $qr->setName('Jagannath');
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=' . $qr->getAmount() .
                                    '&label=' . $qr->getName(), $reader->text());
    }

    public function testBitcoinQrWithRequestAndMessage(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $message = ('Donation for project xyz');
        $qr = new BitcoinQr($address);
        $qr->setAmount(0.000023);
        $qr->setMessage($message);
        $qr->setSize(300);
        $pngData = $qr->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?amount=' . $qr->getAmount()  .
                                    '&message=' . $qr->getMessage(), $reader->text());
    }

    public function testWriteBitcoinQrFile(): void
    {
        $filename = __DIR__ . '/output/bitcoin-qr-code.png';

        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $name = 'Jagannath';
        $message = ('Donation for project xyz');
        $qr = new BitcoinQr($address);
        $qr->setAmount(80);
        $qr->setName($name);
        $qr->setMessage($message);
        $qr->setSize(300);
        $qr->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertTrue(is_resource($image));
    }
}
