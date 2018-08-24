<?php

namespace CryptoQr\Tests;

use PHPUnit\Framework\TestCase;
use CryptoQr\BitcoinQr;
use Zxing\QrReader;

class BitcoinQrTest extends TestCase
{
    public function testBitcoinQrAddress(): void
    {
        $qr = new BitcoinQr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $pngData = $qr->getQrCode()->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', $reader->text());
    }

    public function testBitcoinQrWithLabel(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $qr = new BitcoinQr($address);
        $qr->setLabel('Caritas');
        $pngData = $qr->getQrCode()->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals('bitcoin:' . $address .
                                    '?label=Caritas', $reader->text());
    }

    public function testBitcoinQrWithRequestBtc(): void
    {
        $qr = new BitcoinQr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $qr->setAmount(20.3);
        $qr->setLabel('Caritas');
        $pngData = $qr->getQrCode()->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals(
            'bitcoin:34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY?amount=20.3&label=Caritas',
            $reader->text()
        );
    }

    public function testBitcoinQrWithRequestAndMessage(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $message = ('Donation for project xyz');
        $qr = new BitcoinQr($address);
        $qr->setAmount(0.000023456789);
        $qr->setMessage($message);
        $pngData = $qr->getQrCode()->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals(
            'bitcoin:34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY?amount=0.000023456789'.
            '&message=Donation%20for%20project%20xyz',
            $reader->text()
        );
    }

    public function testBitcoinQrWithMessage(): void
    {
        $message = 'Donation for project xyz';
        $qr = new BitcoinQr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $qr->setMessage($message);
        $pngData = $qr->getQrCode()->writeString();
        $this->assertTrue(is_string($pngData));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertEquals(
            'bitcoin:34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY' .
            '?message=Donation%20for%20project%20xyz',
            $reader->text()
        );
    }

    public function testWriteBitcoinQrFile(): void
    {
        $filename = sys_get_temp_dir() . '/bitcoin-qr-code.png';

        $qr = new BitcoinQr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $qr->setAmount(80);
        $qr->setLabel('Caritas');
        $qr->setMessage('Donation for project xyz');
        $qr->getQrCode()->writeFile($filename);

        $image = imagecreatefromstring(file_get_contents($filename));

        $this->assertTrue(is_resource($image));
    }
    
    public function testBitcoinQr(): void
    {
        $qr = new BitcoinQr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $qr->setAmount(80);
        $qr->setLabel('Caritas');
        $qr->setMessage('Donation for project xyz');
        $data = $qr->getQrCode()->writeString();

        $this->assertTrue(is_string($data));
    }
}
