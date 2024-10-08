<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr;

use Endroid\QrCode\QrCode;

class Qr
{
    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var QrCode
     */
    protected $qr_code;

    public function __construct(string $address = '')
    {
        $this->qr_code = new QrCode($address);
        $this->setAddress($address);
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
        $this->updateText();
    }

    protected function updateText(): void
    {
        $uri = $this->getAddress();

        $this->getQrCode()->setData($uri);
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getQrCode(): QrCode
    {
        return $this->qr_code;
    }
}
