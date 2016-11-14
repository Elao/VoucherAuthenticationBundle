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
     * Voucher
     *
     * @var VoucherInterface|string
     */
    private $voucher;

    /**
     * Constructor
     *
     * @param VoucherInterface|string $voucher
     * @param array $roles
     */
    public function __construct($voucher, array $roles = [])
    {
        parent::__construct($roles);

        $this->voucher = $voucher;
    }

    /**
     * The voucher
     *
     * @return VoucherInterface|string
     */
    public function getCredentials()
    {
        return $this->voucher;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();

        $this->voucher = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([$this->voucher, parent::serialize()]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($str)
    {
        list($this->voucher, $parentStr) = unserialize($str);
        parent::unserialize($parentStr);
    }
}
