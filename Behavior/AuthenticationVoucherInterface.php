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

/**
 * A Voucher dedicated to Authentication
 */
interface AuthenticationVoucherInterface extends VoucherInterface
{
    /**
     * Get username
     *
     * @return string
     */
    public function getUsername();
}
