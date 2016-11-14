<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Voucher token
 */
class VoucherToken extends AbstractToken
{
    /**
     * Credentials (token)
     *
     * @var string
     */
    public $credentials;

    /**
     * {@inheritdoc}
     */
    public function __construct($credentials, array $roles = array())
    {
        parent::__construct($roles);

        $this->credentials = $credentials;
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        parent::eraseCredentials();

        $this->credentials = null;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize(array($this->credentials, parent::serialize()));
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($str)
    {
        list($this->credentials, $parentStr) = unserialize($str);
        parent::unserialize($parentStr);
    }
}
