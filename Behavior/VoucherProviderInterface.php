<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Behavior;

use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherInterface;

/**
 * Voucher provider interface
 */
interface VoucherProviderInterface
{
    /**
     * Get voucher by token and mark it as used (token can only be used once)
     *
     * @param string $token
     *
     * @return Voucher|null
     */
    public function use($token);

    /**
     * Persist the given token
     *
     * @param VoucherInterface $voucher The voucher to save
     *
     * @return boolean Success
     */
    public function persist(VoucherInterface $voucher);
}
