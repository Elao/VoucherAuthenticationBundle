<?php

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
