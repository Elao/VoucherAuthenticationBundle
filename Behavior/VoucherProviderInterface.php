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
     * Persist the given token
     *
     * @param VoucherInterface $voucher The voucher to save
     *
     * @return bool Success
     */
    public function persist(VoucherInterface $voucher);

    /**
     * Get a voucher by its token.
     *
     * @param string $token
     *
     * @return Voucher|null
     */
    public function get($token);

    /**
     * Delete the voucher corresponding to the given token.
     *
     * @param string $token
     *
     * @return Voucher|null
     */
    public function delete($token);
}
