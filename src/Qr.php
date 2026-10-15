<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr;

use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Output\QRGdImagePNG;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use GdImage;
use RuntimeException;

class Qr
{
    protected ?string $logo = null;
    protected int $size = 300;

    public function __construct(
        private string $address = ''
    ) {
        $this->setAddress($address);
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setLogo(string $logo): void
    {
        $this->logo = $logo;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    protected function renderPng(): string
    {
        $image = $this->renderImage(1);
        $moduleCount = imagesx($image);

        $image = $this->renderImage((int) ceil($this->size / $moduleCount));

        if (imagesx($image) !== $this->size) {
            $scaled = imagescale($image, $this->size, $this->size);

            if ($scaled === false) {
                throw new RuntimeException('Unable to scale QR image.');
            }

            $image = $scaled;
        }

        ob_start();
        $written = imagepng($image);
        $png = ob_get_clean();

        if ($written === false || $png === false) {
            throw new RuntimeException('Unable to encode QR image as PNG.');
        }

        return $png;
    }

    public function getString(): string
    {
        return $this->renderPng();
    }

    public function getDataUri(): string
    {
        return 'data:image/png;base64,' . base64_encode($this->renderPng());
    }

    public function writeFile(string $filename): void
    {
        if (file_put_contents($filename, $this->renderPng()) === false) {
            throw new RuntimeException('Unable to write QR image.');
        }
    }

    protected function renderImage(int $scale): GdImage
    {
        $options = new CryptoQrOptions([
            'addLogoSpace' => $this->logo !== null,
            'eccLevel' => EccLevel::H,
            'logoPath' => $this->logo,
            'logoSpaceHeight' => 9,
            'logoSpaceWidth' => 9,
            'outputBase64' => false,
            'outputType' => QROutputInterface::CUSTOM,
            'outputInterface' => $this->logo === null ? QRGdImagePNG::class : QrLogoOutput::class,
            'returnResource' => true,
            'scale' => $scale,
        ]);

        /** @var GdImage */
        return (new QRCode($options))->render($this->getPayload());
    }

    protected function getPayload(): string
    {
        return $this->address;
    }
}
