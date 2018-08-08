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
     * @var null|float
     */
    protected $amount;
    /**
     * @var null|string
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
        return !empty($this->getAddress());
    }

    private function addName(string $name): void
    {
        $rawname = rawurlencode($name);
        $this->name = $rawname;
        $uri = $this->getText();
        $uri .= !empty($this->getAmount()) ? '&' : '?';
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
        $uri .= !empty($this->getAmount()) || !empty($this->getName()) ? '&' : '?';
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
     * @return null|float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return null|string
     */
    public function getName()
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