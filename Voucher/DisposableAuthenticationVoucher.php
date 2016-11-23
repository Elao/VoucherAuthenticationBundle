<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Voucher;

use DateTime;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\AuthenticationVoucherInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\DisposableVoucherInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\TimedVoucherInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherInterface;

/**
 * Voucher
 */
class DisposableAuthenticationVoucher implements VoucherInterface, AuthenticationVoucherInterface, TimedVoucherInterface, DisposableVoucherInterface
{
    /**
     * Random 32 character length string
     *
     * @var string
     */
    protected $token;

    /**
     * Username
     *
     * @var string
     */
    protected $username;

    /**
     * Expiration date
     *
     * @var DateTime
     */
    protected $expiration;

    /**
     * Constructor
     *
     * @param string $username Username for UserProvider
     * @param string $ttl      Time to live (support for DateTime constructor)
     */
    public function __construct($username, $ttl = '+15 minutes')
    {
        $this->username = $username;
        $this->expiration = new DateTime($ttl);
        $this->token = static::generateToken();
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get expiration
     *
     * @return DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Is expired?
     *
     * @return bool
     */
    public function isExpired()
    {
        return new DateTime() > $this->expiration;
    }

    /**
     * Generate token
     *
     * @return string
     */
    public static function generateToken()
    {
        return md5(random_bytes(10));
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize([
            $this->token,
            $this->username,
            $this->expiration,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->token, $this->username, $this->expiration) = unserialize($serialized);
    }
}
