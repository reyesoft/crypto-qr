<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr;

use Endroid\QrCode\Logo\LogoInterface;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;

class Qr
{
    /**
     * @var string
     */
    protected $address = '';
    /**
     * @var PngWriter
     */
    protected $writer;
    /**
     * @var LogoInterface|null
     */
    protected $logo;
    /**
     * @var QrCode
     */
    protected $qr_code;

    public function __construct(string $address = '')
    {
        $this->qr_code = new QrCode($address);
        $this->setAddress($address);
        $this->writer = new PngWriter();
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

    public function setLogo(LogoInterface $logo): void
    {
        $this->logo = $logo;
    }

    public function getQrCode(): QrCode
    {
        return $this->qr_code;
    }

    private function writerResult(): ResultInterface
    {
        return $this->writer->write($this->getQrCode(), $this->logo);
    }

    public function getString(): string
    {
        return $this->writerResult()->getString();
    }

    public function getDataUri(): string
    {
        return $this->writerResult()->getDataUri();
    }

    public function writeFile(string $filename): void
    {
        $this->writerResult()->saveToFile($filename);
    }
}
