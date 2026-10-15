<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr\Tests;

use CryptoQr\Qr;
use PHPUnit\Framework\TestCase;
use Zxing\QrReader;

/**
 * @internal
 *
 * @covers \CryptoQr\Qr
 */
final class QrTest extends TestCase
{
    public function testQrAddress(): void
    {
        $qr = new Qr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $pngData = $qr->getString();

        $this->assertSame("\x89PNG\r\n\x1a\n", substr($pngData, 0, 8));
        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', $reader->text());
    }

    public function testQrUri(): void
    {
        $qr = new Qr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $pngUri = $qr->getDataUri();
        $pngData = base64_decode(substr($pngUri, 22), true);

        $this->assertStringStartsWith('data:image/png;base64,', $pngUri);
        $this->assertNotFalse($pngData);
        $this->assertSame("\x89PNG\r\n\x1a\n", substr((string) $pngData, 0, 8));
        $this->assertNotFalse(imagecreatefromstring((string) $pngData));
        $this->assertSame('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', (new QrReader((string) $pngData, QrReader::SOURCE_TYPE_BLOB))->text());
    }

    public function testSetQrLogo(): void
    {
        $qr = new Qr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $qr->setLogo(__DIR__ . '/resources/img/BTC.png');
        $qr->setSize(200);
        $pngData = $qr->getString();

        $image = imagecreatefromstring($pngData);
        $this->assertNotFalse($image);
        $this->assertSame(200, imagesx($image));
        $this->assertSame(200, imagesy($image));
        $hasLogoColor = false;

        for ($y = 70; $y < 130; $y++) {
            for ($x = 70; $x < 130; $x++) {
                $color = imagecolorsforindex($image, imagecolorat($image, $x, $y));

                if ($color['red'] > 200 && $color['green'] > 50 && $color['green'] < 200 && $color['blue'] < 80) {
                    $hasLogoColor = true;
                }
            }
        }

        $this->assertTrue($hasLogoColor);
        $this->assertSame('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', (new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB))->text());
    }

    public function testWriteQrFile(): void
    {
        $filename = sys_get_temp_dir() . '/qr-code.png';

        $qr = new Qr('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY');
        $qr->writeFile($filename);

        $pngData = (string) file_get_contents($filename);
        $image = imagecreatefromstring($pngData);

        $this->assertNotFalse($image);
        $this->assertSame("\x89PNG\r\n\x1a\n", substr($pngData, 0, 8));
        $this->assertSame('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', (new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB))->text());
    }
}
