<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherInterface;

/**
 * Voucher token
 */
class VoucherToken extends AbstractToken
{
    /**
     * Constructor
     *
     * @param VoucherInterface|string $voucher
     * @param array $roles
     */
    public function __construct($voucher, array $roles = [])
    {
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
