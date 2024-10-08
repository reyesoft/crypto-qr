<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr\Tests;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use PHPUnit\Framework\TestCase;
use Zxing\QrReader;

/**
 * @internal
 *
 * @covers \CryptoQr\EthereumQr
 */
final class EthereumQrTest extends TestCase
{
    public function testEthereumQrAddress(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('ethereum:' . $address)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();
        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);

        $this->assertSame('ethereum:' . $address, $reader->text());
    }

    public function testEthereumQrWithLabel(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $label = 'Caritas';
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('ethereum:' . $address . '?label=' . urlencode($label))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();
        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);

        $this->assertSame('ethereum:' . $address . '?label=' . urlencode($label), $reader->text());
    }

    public function testEthereumQrWithRequestEth(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $amount = 20.3;
        $label = 'Caritas';
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('ethereum:' . $address . '?amount=' . $amount . '&label=' . urlencode($label))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();
        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);

        $this->assertSame(
            'ethereum:' . $address . '?amount=' . $amount . '&label=' . urlencode($label),
            $reader->text()
        );
    }

    public function testEthereumQrWithRequestAndMessage(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $amount = 0.000023456789;
        $message = 'Donation for project xyz';
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('ethereum:' . $address . '?amount=' . $amount . '&message=' . urlencode($message))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'ethereum:' . $address . '?amount=' . $amount . '&message=' . urlencode($message),
            $reader->text()
        );
    }

    public function testEthereumQrWithMessage(): void
    {
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $message = 'Donation for project xyz';
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('ethereum:' . $address . '?message=' . urlencode($message))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'ethereum:' . $address . '?message=' . urlencode($message),
            $reader->text()
        );
    }

    public function testWriteEthereumQrFile(): void
    {
        $filename = sys_get_temp_dir() . '/ethereum-qr-code.png';
        $address = '0xe8ecDFacE0b274042aAD072149eEc3e232586499';
        $amount = 80;
        $label = 'Caritas';
        $message = 'Donation for project xyz';
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('ethereum:' . $address . '?amount=' . $amount . '&label=' . urlencode($label) . '&message=' . urlencode($message))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $qrCode->saveToFile($filename);

        $image = imagecreatefromstring((string) file_get_contents($filename));
        $this->assertInstanceOf(\GdImage::class, $image);
    }
}
