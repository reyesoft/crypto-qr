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
 * @covers \CryptoQr\Qr
 */
final class QrTest extends TestCase
{
    public function testQrAddress(): void
    {
        $address = '34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY';

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
}
