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

class CryptoQr extends Qr
{
    /**
     * @var float
     */
    protected $amount = .0;

    /**
     * @var string
     */
    protected $label = '';

    /**
     * @var string
     */
    protected $message = '';
    /**
     * @var QrCode
     */
    protected $qr_code;

    /**
     * @codeCoverageIgnore
     */
    protected function getAddressProtocol(): string
    {
        return '';
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
        $this->updateText();
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
        $this->updateText();
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
        $this->updateText();
    }

    protected function updateText(): void
    {
        $uri = empty($this->getAddressProtocol()) ? '' : $this->getAddressProtocol() . ':';
        $uri .= $this->getAddress();
        $params = $this->getParam('amount', $this->getAmountString()) .
            $this->getParam('label', $this->getLabel()) .
            $this->getParam('message', $this->getMessage());

        $this->qr_code = new QrCode($uri . ($params !== '' ? '?' . substr($params, 1) : ''));
    }

    private function getParam(string $label, string $value): string
    {
        return !empty($value) ? '&' . $label . '=' . rawurlencode($value) : '';
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAmountString(): string
    {
        $amount = $this->getAmount();
        $string = (string) $amount;

        /** @var array{array, $matches int, string, int} */
        if (preg_match('~\.(\d+)E([+-])?(\d+)~', $string, $matches) === 1) {
            $decimals = $matches[2] === '-' ? strlen($matches[1]) + $matches[3] : 0;
            $string = number_format($amount, (int) $decimals, '.', '');
        }

        return $string;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
