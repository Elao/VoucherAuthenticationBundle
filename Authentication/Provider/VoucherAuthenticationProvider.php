<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Authentication\Provider;

use Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token\VoucherToken;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\AuthenticationVoucherInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherProviderInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class VoucherAuthenticationProvider implements AuthenticationProviderInterface
{
    /**
     * Voucher provider
     *
     * @var UserProviderInterface
     */
    private $userProvider;

    /**
     * Voucher provider
     *
     * @var VoucherProviderInterface
     */
    private $voucherProvider;

    /**
     * Constructor
     *
     * @param UserProviderInterface    $userProvider
     * @param VoucherProviderInterface $voucherProvider
     */
    public function __construct(UserProviderInterface $userProvider, VoucherProviderInterface $voucherProvider)
    {
        $this->userProvider = $userProvider;
        $this->voucherProvider = $voucherProvider;
    }

    /**
     * {@inhertidoc}
     */
    public function authenticate(TokenInterface $token)
    {
        $voucher = $this->voucherProvider->get($token->getAttribute('voucher'));

        if (!$voucher || !$voucher instanceof AuthenticationVoucherInterface) {
            throw new AuthenticationException('No valid token found.');
        }

        if ($voucher instanceof DisposableVoucherInterface) {
            $this->voucherProvider->delete($voucher->getToken());
        }

        if ($voucher->isExpired()) {
            throw new AuthenticationException('Token has expired.');
        }

        $user = $this->userProvider->loadUserByUsername($voucher->getUsername());

        if (!$user) {
            throw new AuthenticationException('User not found.');
        }

        $authenticatedToken = new VoucherToken($voucher, $user->getRoles());
        $authenticatedToken->setAuthenticated(true);
        $authenticatedToken->setUser($user);

        return $authenticatedToken;
    }

    /**
     * {@inhertidoc}
     */
    public function supports(TokenInterface $token)
    {
        return $token instanceof VoucherToken;
    }
}
