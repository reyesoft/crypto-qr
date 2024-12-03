<?php
/**
 * Copyright (C) 1997-2020 Reyesoft <info@reyesoft.com>.
 *
 * This file is part of CryptoQr. CryptoQr can not be copied and/or
 * distributed without the express permission of Reyesoft
 */

declare(strict_types=1);

namespace CryptoQr;

class EthereumQr extends CryptoQr
{
    protected function getAddressProtocol(): string
    {
        return 'ethereum';
    }
}
