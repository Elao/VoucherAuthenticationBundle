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
 * Voucher interface with intent
 */
interface IntentedVoucherInterface extends VoucherInterface
{
    /**
     * Get intent
     *
     * @return string
     */
    public function getIntent();
}
