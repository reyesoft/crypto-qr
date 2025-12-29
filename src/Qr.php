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
     * @var PngWriter
     */
    protected $writer;
    /**
     * @var LogoInterface|null
     */
    protected $logo;
    protected ?int $size = 300;

    public function __construct(
        private string $address = ''
    ) {
        $this->setAddress($address);
        $this->writer = new PngWriter();
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setLogo(LogoInterface $logo): void
    {
        $this->logo = $logo;
    }

    protected function writerResult(): ResultInterface
    {
        return $this->writer->write(
            new QrCode(
                data: $this->address,
                size: $this->size
            ),
            $this->logo
        );
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
