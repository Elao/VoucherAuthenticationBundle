<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Authentication\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token\VoucherToken;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\VoucherProviderInterface;

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
     * @param UserProviderInterface $userProvider
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
        $voucher = $this->voucherProvider->use($token->getCredentials());

        if (!$voucher || $voucher->isExpired()) {
            throw new AuthenticationException('No valid token found.');
        }

        $user = $this->userProvider->loadUserByUsername($voucher->getUsername());

        if (!$user) {
            throw new AuthenticationException('User not found.');
        }

        $authenticatedToken = new VoucherToken($token->getCredentials(), $user->getRoles());
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
