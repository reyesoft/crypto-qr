<?php

namespace CryptoQr;

use Endroid\QrCode\QrCode;

class BitcoinQr extends QrCode
{
    protected $address;
    protected $amount;
    protected $name;
    protected $message;

    public function __construct(string $text = '')
    {
        $this->address = $text;
        parent::__construct('bitcoin:' . $this->address);
    }

    public function setName(string $name)
    {
        if ($this->addressCheck()) {
            $this->addName($name);
        }
    }

    public function setAmount(float $amount)
    {
        if ($this->addressCheck()) {
            $this->addAmount($amount);
        }
    }

    public function setMessage(string $message)
    {
        if ($this->addressCheck()) {
            $this->addMessage($message);
        }
    }

    private function addressCheck()
    {
        if (!is_null($this->address)) {
            return true;
        } else {
            return false;
        }
    }

    private function addName(string $name)
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

    private function addAmount(float $amount)
    {
        $this->amount = $amount;
        $uri = $this->getText();
        $uri .= '?amount=' . $amount;
        $this->setText($uri);
    }

    private function addMessage(string $message)
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
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }
}