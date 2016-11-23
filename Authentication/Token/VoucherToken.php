<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token;

use Elao\Bundle\VoucherAuthenticationBundle\Behavior\AuthenticationVoucherInterface;
use InvalidArgumentException;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Voucher token
 */
class VoucherToken extends AbstractToken
{
    /**
     * Constructor
     *
     * @param VoucherInterface|string $voucher
     * @param array                   $roles
     */
    public function __construct($voucher, array $roles = [])
    {
        if (!is_string($voucher) && !$voucher instanceof AuthenticationVoucherInterface) {
            throw new InvalidArgumentException(sprintf(
                'VoucherToken expect a string or an instance of "%s"',
                AuthenticationVoucherInterface::class
            ));
        }

        parent::__construct($roles);

        $this->setAttribute('voucher', $voucher);
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return null;
    }
}
