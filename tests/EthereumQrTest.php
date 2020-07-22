<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr\Tests;

use CryptoQr\EthereumQr;
use PHPUnit\Framework\TestCase;
use Zxing\QrReader;

/**
 * @internal
 * @covers \CryptoQr\EthereumQr
 */
final class EthereumQrTest extends TestCase
{
    public function testEthereumQrAddress(): void
    {
        $qr = new EthereumQr('0xe8ecDFacE0b274042aAD072149eEc3e232586499');
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('ethereum:0xe8ecDFacE0b274042aAD072149eEc3e232586499', $reader->text());
    }

    public function testEthereumQrWithLabel(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $qr = new EthereumQr($address);
        $qr->setLabel('Caritas');
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('ethereum:' . $address .
                                    '?label=Caritas', $reader->text());
    }

    public function testEthereumQrWithRequestEth(): void
    {
        $qr = new EthereumQr('0xe8ecDFacE0b274042aAD072149eEc3e232586499');
        $qr->setAmount(20.3);
        $qr->setLabel('Caritas');
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'ethereum:0xe8ecDFacE0b274042aAD072149eEc3e232586499?amount=20.3&label=Caritas',
            $reader->text()
        );
    }

    public function testEthereumQrWithRequestAndMessage(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $message = ('Donation for project xyz');
        $qr = new EthereumQr($address);
        $qr->setAmount(0.000023456789);
        $qr->setMessage($message);
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'ethereum:0xe8ecDFacE0b274042aAD072149eEc3e232586499?amount=0.000023456789' .
            '&message=Donation%20for%20project%20xyz',
            $reader->text()
        );
    }

    public function testEthereumQrWithMessage(): void
    {
        $message = 'Donation for project xyz';
        $qr = new EthereumQr('0xe8ecDFacE0b274042aAD072149eEc3e232586499');
        $qr->setMessage($message);
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'ethereum:0xe8ecDFacE0b274042aAD072149eEc3e232586499' .
            '?message=Donation%20for%20project%20xyz',
            $reader->text()
        );
    }

    public function testWriteEthereumQrFile(): void
    {
        $filename = sys_get_temp_dir() . '/bitcoin-qr-code.png';

        $qr = new EthereumQr('0xe8ecDFacE0b274042aAD072149eEc3e232586499');
        $qr->setAmount(80);
        $qr->setLabel('Caritas');
        $qr->setMessage('Donation for project xyz');
        $qr->getQrCode()->writeFile($filename);

        $image = imagecreatefromstring((string) file_get_contents($filename));

        $this->assertIsResource($image);
    }
}
