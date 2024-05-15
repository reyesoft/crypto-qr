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
 * @covers \CryptoQr\DefaultQr
 */
final class DefaultQrTest extends TestCase
{
    public function testQrAddress(): void
    {
        $address = '00020101021226790014br.gov.bcb.pix2557brcode.starkinfra.com/v2/e31f78164ecb4deb9c7efce0bcba7a5b5204000053039865802BR5925Smartpay Servicos Digitai6013Florianopolis62070503***6304CC0F';
        $qr = new Qr(urldecode($address));
        $pngData = $qr->getQrCode()->writeString();

        $reader = new QrReader($pngData, QrReader::SOURCE_TYPE_BLOB);
        $this->assertSame($address, $reader->text());
    }
}
