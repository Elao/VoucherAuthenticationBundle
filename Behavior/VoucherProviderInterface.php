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
     * @return bool Success
     */
    public function persist(VoucherInterface $voucher);
}
