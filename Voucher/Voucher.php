<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Voucher;

use DateTime;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherInterface;

/**
 * Voucher
 */
class Voucher implements VoucherInterface
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
     * @param string $username
     * @param string $ttl
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
     * @return boolean
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
