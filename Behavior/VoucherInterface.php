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

use DateTime;
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
     * Get username
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get username
     *
     * @return string
     */
    public function getExpiration();

    /**
     * Is expired?
     *
     * @param DateTime $date Run the test on a specific date (other current time is used)
     *
     * @return bool
     */
    public function isExpired(DateTime $date = null);
}
