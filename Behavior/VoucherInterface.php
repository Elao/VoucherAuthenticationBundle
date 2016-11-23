<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Behavior;

use Serializable;

/**
 * Voucher interface
 */
interface VoucherInterface extends Serializable
{
    /**
     * Get token
     *
     * @return string
     */
    public function getToken();

    /**
     * Is the voucher expired?
     *
     * @return bool
     */
    public function isExpired();
}
