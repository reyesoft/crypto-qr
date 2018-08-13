<?php

namespace CryptoQr;

use Endroid\QrCode\QrCode;

class BitcoinQr
{
    /**
     * @var string
     */
    protected $address = '';

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

    public function __construct(string $address = '')
    {
        $this->qr_code = new QrCode();
        $this->setAddress($address);
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
        $this->updateText();
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

    private function updateText(): void
    {
        $uri = 'bitcoin:'.$this->getAddress();
        $params =
            $this->getParam('amount', $this->getAmountString()) .
            $this->getParam('label', $this->getLabel()) .
            $this->getParam('message', $this->getMessage());

        $this->getQrCode()->setText(
            $uri .
            ($params ? '?'.substr($params, 1):'')
        );
    }

    private function getParam(string $label, string $value): string {
        return $value ? '&'.$label.'='.rawurlencode($value) : '';
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getAmountString(): string
    {
        $amount = $this->getAmount();
        $string = (string)$amount;

        if (preg_match('~\.(\d+)E([+-])?(\d+)~', $string, $matches)) {
            $decimals = $matches[2] === '-' ? strlen($matches[1]) + $matches[3] : 0;
            $string = number_format($amount, $decimals,'.','');
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

    public function getQrCode(): QrCode {
        return $this->qr_code;
    }
}
