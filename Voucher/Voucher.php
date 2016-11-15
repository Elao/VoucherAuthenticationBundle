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
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\IntentedVoucherInterface;

/**
 * Voucher
 */
class Voucher implements IntentedVoucherInterface
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
     * Intent
     *
     * @var string
     */
    protected $intent;

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
     * @param string $intent   Intent: e.g. authenticate, forgot-password, validate-email,...
     * @param string $ttl
     */
    public function __construct($username, $intent = 'authenticate', $ttl = '+15 minutes')
    {
        $this->username = $username;
        $this->intent = $intent;
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
     * Get intent
     *
     * @return string
     */
    public function getIntent()
    {
        return $this->intent;
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
    public function isExpired(DateTime $date = null)
    {
        return ($date ?: new DateTime()) > $this->expiration;
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
            $this->intent,
            $this->expiration,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        list($this->token, $this->username, $this->intent, $this->expiration) = unserialize($serialized);
    }
}
