<?php

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
     * @param DateTime $date Run the test on a specific date (other current time is used).
     *
     * @return boolean
     */
    public function isExpired(DateTime $date = null);
}
