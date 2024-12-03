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
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame('34ZwZ4cYiwZnYquM4KW67sqT7vY88215CY', $reader->text());
    }
}
