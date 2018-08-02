<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Reyesoft\CryptoQr\Factory;

use Reyesoft\CryptoQr\QrCodeInterface;

interface QrCodeFactoryInterface
{
    public function create(string $text = '', array $options = []): QrCodeInterface;
}
