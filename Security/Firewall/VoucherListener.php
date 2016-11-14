<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\Security\Http\ParameterBagUtils;
use Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token\VoucherToken;

class VoucherListener extends AbstractAuthenticationListener
{
    /**
     * {@inheritdoc}
     */
    public function attemptAuthentication(Request $request)
    {
        if (!$token = ParameterBagUtils::getRequestParameterValue($request, $this->options['token_parameter'])) {
            throw new BadCredentialsException('No token provided.');
        }

        return $this->authenticationManager->authenticate(new VoucherToken($token));
    }
}
