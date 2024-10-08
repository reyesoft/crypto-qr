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
 * @covers \CryptoQr\CryptoQr
 */
final class CryptoQrTest extends TestCase
{
    public function testBitcoinQrAddress(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('bitcoin:' . $address, $reader->text());
    }

    public function testQrAddressWithoutProtocol(): void
    {
        $address = 'TLPF4HgzmJgQc2oDmR8Msxq4LeUfkA4n4W';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data($address)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame($address, $reader->text());
    }

    public function testBitcoinQrWithLabel(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $label = 'Caritas';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?label=' . urlencode($label))  // Incluir label en el formato del QR
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('bitcoin:' . $address . '?label=' . $label, $reader->text());
    }

    public function testBitcoinQrWithRequestBtc(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $amount = 20.3;
        $label = 'Caritas';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?amount=' . $amount . '&label=' . urlencode($label))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $pngData = $qrCode->getString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame(
            'bitcoin:' . $address . '?amount=' . $amount . '&label=' . $label,
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

        $pngData = $qrCode->getString();

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
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';
        $amount = 80;
        $label = 'Caritas';
        $message = 'Donation for project xyz';

        $filename = sys_get_temp_dir() . '/bitcoin-qr-code.png';

        $qrCode = Builder::create()
            ->writer(new PngWriter())
            ->data('bitcoin:' . $address . '?amount=' . $amount . '&label=' . urlencode($label) . '&message=' . urlencode($message))
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(ErrorCorrectionLevel::High)
            ->size(300)
            ->margin(10)
            ->build();

        $qrCode->saveToFile($filename);

        $image = imagecreatefromstring((string) file_get_contents($filename));
        $this->assertNotFalse($image);  // Verifica que la imagen se haya cargado correctamente
    }
}
