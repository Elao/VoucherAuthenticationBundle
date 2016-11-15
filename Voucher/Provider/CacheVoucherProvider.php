<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Voucher\Provider;

use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherProviderInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Voucher\Voucher;
use Psr\Cache\CacheItemPoolInterface;

class CacheVoucherProvider implements VoucherProviderInterface
{
    /**
     * Cache
     *
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * Constructor
     *
     * @param CacheItemPoolInterface $cache
     */
    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * {@inhertidoc}
     */
    public function persist(VoucherInterface $voucher)
    {
        $key = $this->getCacheKey($voucher->getToken());
        $item = $this->cache->getItem($key);

        $item->set($voucher);
        $item->expiresAt($voucher->getExpiration());

        return $this->cache->save($item);
    }

    /**
     * {@inheritdoc}
     */
    public function use($token)
    {
        if ($voucher = $this->getByToken($token)) {
            $this->deleteByToken($token);
        }

        return $voucher;
    }

    /**
     * Delete the voucher corresponding to the given token
     *
     * @param string $token
     *
     * @return boolen success
     */
    private function deleteByToken($token)
    {
        return $this->cache->deleteItem($this->getCacheKey($token));
    }

    /**
     * {@inhertidoc}
     */
    private function getByToken($token)
    {
        return $this->cache->getItem($this->getCacheKey($token))->get();
    }

    /**
     * Get cache key by token
     *
     * @param string $token
     *
     * @return string
     */
    private function getCacheKey($token)
    {
        return sprintf('voucher-%s', $token);
    }
}
