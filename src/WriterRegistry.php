<?php

/*
 * (c) Jeroen van den Enden <info@endroid.nl>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Reyesoft\CryptoQr;

use Reyesoft\CryptoQr\Exception\InvalidWriterException;
use Reyesoft\CryptoQr\Writer\BinaryWriter;
use Reyesoft\CryptoQr\Writer\DebugWriter;
use Reyesoft\CryptoQr\Writer\EpsWriter;
use Reyesoft\CryptoQr\Writer\PngWriter;
use Reyesoft\CryptoQr\Writer\SvgWriter;
use Reyesoft\CryptoQr\Writer\WriterInterface;

class WriterRegistry implements WriterRegistryInterface
{
    private $writers = [];
    private $defaultWriter;

    public function loadDefaultWriters(): void
    {
        if (count($this->writers) > 0) {
            return;
        }

        $this->addWriters([
            new BinaryWriter(),
            new DebugWriter(),
            new EpsWriter(),
            new PngWriter(),
            new SvgWriter(),
        ]);

        $this->setDefaultWriter('png');
    }

    public function addWriters(iterable $writers): void
    {
        foreach ($writers as $writer) {
            $this->addWriter($writer);
        }
    }

    public function addWriter(WriterInterface $writer): void
    {
        $this->writers[$writer->getName()] = $writer;
    }

    public function getWriter(string $name): WriterInterface
    {
        $this->assertValidWriter($name);

        return $this->writers[$name];
    }

    public function getDefaultWriter()
    {
        if ($this->defaultWriter instanceof WriterInterface) {
            return $this->defaultWriter;
        }

        throw new InvalidWriterException('Please set the default writer via the second argument of addWriter');
    }

    public function setDefaultWriter(string $name)
    {
        $this->defaultWriter = $this->writers[$name];
    }

    public function getWriters(): array
    {
        return $this->writers;
    }

    private function assertValidWriter(string $name)
    {
        if (!isset($this->writers[$name])) {
            throw new InvalidWriterException('Invalid writer "'.$name.'"');
        }
    }
}
