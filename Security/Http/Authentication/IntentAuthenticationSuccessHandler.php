<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Security\Http\Authentication;

use Elao\Bundle\VoucherAuthenticationBundle\Authentication\Token\VoucherToken;
use Elao\Bundle\VoucherAuthenticationBundle\Behavior\IntentedVoucherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Http\HttpUtils;

/**
 * Adds intented voucher authentication success handling logic to default behavior.
 */
class IntentAuthenticationSuccessHandler extends DefaultAuthenticationSuccessHandler
{
    /**
     * {@inheritdoc}
     */
    public function __construct(HttpUtils $httpUtils, array $options = [])
    {
        $this->defaultOptions['target_paths'] = [];

        parent::__construct($httpUtils, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        if ($token instanceof VoucherToken && $token->getAttribute('voucher') instanceof IntentedVoucherInterface) {
            $url = $this->determineVoucherUrl($request, $token->getAttribute('voucher'));

            return $this->httpUtils->createRedirectResponse($request, $url);
        }

        return parent::onAuthenticationSuccess($request, $token);
    }

    /**
     * Builds the target URL for the given voucher.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function determineVoucherUrl(Request $request, IntentedVoucherInterface $voucher)
    {
        if ($path = $this->getPathByIntent($voucher->getIntent())) {
            return $path;
        }

        return parent::determineTargetUrl($request);
    }

    /**
     * Get path by intent
     *
     * @param string $intent Voucher intent
     *
     * @return string Path
     */
    public function getPathByIntent($intent)
    {
        if (isset($this->options['target_paths'][$intent])) {
            return $this->options['target_paths'][$intent]['path'];
        }

        return null;
    }
}
