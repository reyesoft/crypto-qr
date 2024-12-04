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
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Writer\PngWriter;
use PHPUnit\Framework\TestCase;
use Zxing\QrReader;

/**
 * @internal
 *
 * @covers \CryptoQr\BitcoinQr
 * @covers \CryptoQr\CryptoQr
 */
final class BitcoinQrTest extends TestCase
{
    public function testBitcoinQrAddress(): void
    {
        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY')
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('bitcoin:34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', $reader->text());
    }

    public function testBitcoinQrWithLabel(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $labelText = 'Caritas';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?label=' . $labelText)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->labelText($labelText)
            ->labelAlignment(LabelAlignment::Center)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('bitcoin:' . $address . '?label=' . $labelText, $reader->text());
    }

    public function testBitcoinQrWithRequestBtc(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $amount = 20.3;
        $labelText = 'Caritas';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?amount=' . $amount . '&label=' . $labelText)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->labelText($labelText)
            ->labelAlignment(LabelAlignment::Center)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'bitcoin:' . $address . '?amount=' . $amount . '&label=' . $labelText,
            $reader->text()
        );
    }

    public function testBitcoinQrWithRequestAndMessage(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $amount = 0.000023456789;
        $message = 'Donation for project xyz';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?amount=' . $amount . '&message=' . urlencode($message))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString(); // Obtenemos el QR generado en formato PNG como string

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'bitcoin:' . $address . '?amount=' . $amount . '&message=' . urlencode($message),
            $reader->text()
        );
    }

    public function testBitcoinQrWithMessage(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $message = 'Donation for project xyz';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?message=' . urlencode($message))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'bitcoin:' . $address . '?message=' . urlencode($message),
            $reader->text()
        );
    }

    public function testWriteBitcoinQrFile(): void
    {
        $filename = sys_get_temp_dir() . '/bitcoin-qr-code.png';

        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $amount = 80;
        $labelText = 'Caritas';
        $message = 'Donation for project xyz';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?amount=' . $amount . '&label=' . $labelText . '&message=' . urlencode($message)) // Agregamos la información necesaria
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $qrCode->saveToFile($filename); // El método no retorna nada

        $this->assertFileExists($filename); // Verificamos que el archivo existe

        $image = imagecreatefromstring((string) file_get_contents($filename));

        $this->assertNotFalse($image);
    }
}
