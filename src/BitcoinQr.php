<?php

namespace CryptoQr;

use Endroid\QrCode\QrCode;

/**
 * Class BitcoinQr
 * @package CryptoQr
 */
class BitcoinQr extends QrCode
{
    /**
     * @var string
     */
    protected $address;
    /**
     * @var float
     */
    protected $amount;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $message;

    /**
     * BitcoinQr constructor.
     *
     * @param string $address
     */
    public function __construct(string $address = '')
    {
        $this->address = $address;
        parent::__construct('bitcoin:' . $this->address);
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        if ($this->addressCheck()) {
            $this->addName($name);
        }
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        if ($this->addressCheck()) {
            $this->addAmount($amount);
        }
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        if ($this->addressCheck()) {
            $this->addMessage($message);
        }
    }

    private function addressCheck(): bool
    {
        if (!is_null($this->address)) {
            return true;
        } else {
            return false;
        }
    }

    private function addName(string $name): void
    {
        $rawname = rawurlencode($name);
        $this->name = $rawname;
        $uri = $this->getText();
        if (!is_null($this->getAmount())) {
            $uri .= '&';
        } else {
            $uri .= '?';
        }
        $uri .= 'label=' . $rawname;
        $this->setText($uri);
    }

    private function addAmount(float $amount): void
    {
        $this->amount = $amount;
        $uri = $this->getText();
        $uri .= '?amount=' . $amount;
        $this->setText($uri);
    }

    private function addMessage(string $message): void
    {
        $rawmessage = rawurlencode($message);
        $this->message = $rawmessage;
        $uri = $this->getText();
        if (!is_null($this->getAmount())) {
            $uri .= '&';
        } else {
            $uri .= '?';
        }
        $uri .= 'message=' . $rawmessage;
        $this->setText($uri);
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}