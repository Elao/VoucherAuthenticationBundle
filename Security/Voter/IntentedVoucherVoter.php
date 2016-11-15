<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Security\Voter;

use Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token\VoucherToken;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\IntentedVoucherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class IntentedVoucherVoter extends Voter
{
    const VOUCHER = 'voucher';

    /**
     * {@inhertidoc}
     */
    protected function supports($attribute, $subject)
    {
        return $attribute === static::VOUCHER;
    }

    /**
     * {@inhertidoc}
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        if (!$token instanceof VoucherToken) {
            return false;
        }

        $voucher = $token->getAttribute('voucher');

        if (!$voucher instanceof IntentedVoucherInterface) {
            return false;
        }

        return $subject === $voucher->getIntent();
    }
}
