<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr;

use chillerlan\QRCode\Output\QRGdImagePNG;
use RuntimeException;

class QrLogoOutput extends QRGdImagePNG
{
    protected function setTransparencyColor(): void
    {
        parent::setTransparencyColor();
        $logoPath = $this->options->logoPath;

        if ($logoPath === null) {
            return;
        }

        $logo = imagecreatefrompng($logoPath);

        if ($logo === false) {
            throw new RuntimeException('Unable to create logo image from PNG.');
        }

        $logoWidth = imagesx($logo);
        $logoHeight = imagesy($logo);
        $spaceWidth = ($this->options->logoSpaceWidth ?? $this->options->logoSpaceHeight ?? 0) * $this->scale;
        $spaceHeight = ($this->options->logoSpaceHeight ?? $this->options->logoSpaceWidth ?? 0) * $this->scale;
        $ratio = min($spaceWidth / $logoWidth, $spaceHeight / $logoHeight);
        $width = (int) floor($logoWidth * $ratio);
        $height = (int) floor($logoHeight * $ratio);

        imagecopyresampled(
            $this->image,
            $logo,
            (int) (($this->length - $width) / 2),
            (int) (($this->length - $height) / 2),
            0,
            0,
            $width,
            $height,
            $logoWidth,
            $logoHeight
        );
        imagedestroy($logo);
    }
}
