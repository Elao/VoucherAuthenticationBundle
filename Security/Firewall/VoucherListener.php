<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Security\Firewall;

use Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token\VoucherToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\Security\Http\ParameterBagUtils;

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
