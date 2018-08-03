<?php

namespace CryptoQr;

use Endroid\QrCode\QrCode;

class BitcoinQr extends QrCode
{
    protected $address;
    protected $amount;
    protected $name;
    protected $message;
    protected $unit;

    public function __construct(string $text = '')
    {
        $this->address = $text;
        parent::__construct('bitcoin:' . $this->address);
    }

    public function uriWithName(string $name)
    {
        if ($this->addressCheck()) {
            $this->addName($name);
        }
    }

    public function uriWithAmount(float $amount, string $unit)
    {
        if ($this->addressCheck()) {
            $this->addAmount($amount, $unit);
        }
    }

    public function uriWithMessage(string $message)
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
        if (!is_null($this->getAmount())) {
            $this->name = $name;
            $uri = $this->getText();
            $uri .= '&label=' . $name;
            $this->setText($uri);
        } else {
            $this->name = $name;
            $uri = $this->getText();
            $uri .= '?label=' . $name;
            $this->setText($uri);
        }
    }

    private function addAmount(float $amount, string $unit)
    {
        $this->amount = $amount;
        $uri = $this->getText();
        if (in_array($unit, ['BTC', 'btc'], true)) {
            $this->unit = 'BTC';
            $uri .= '?amount=' . $amount . 'X8';
            $this->setText($uri);
        } elseif (in_array($unit, ['TBC', 'tbc'], true)) {
            $this->unit = 'TBC';
            if ($amount > 1000 && $amount < 10000) {
                $this->amount = $amount/1000;
                $uri .= '?amount=x' . $this->amount . 'X7';
                $this->setText($uri);
            } else {
                $uri .= '?amount=x' . $amount . 'X4';
                $this->setText($uri);
            }
        } elseif (in_array($unit, ['uBTC', 'ubtc'], true)) {
            $this->unit = 'uBTC';
            $uri .= '?amount=' . $amount . 'X2';
            $this->setText($uri);
        }
    }

    private function addMessage(string $message)
    {
        $rawurl = rawurlencode($message);
        $this->message = $rawurl;
        $uri = $this->getText();
        $uri .= '&message=' . $message;
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

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }


}