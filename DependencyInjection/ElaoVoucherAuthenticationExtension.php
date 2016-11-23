<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Elao Voucher Authentication extension
 */
class ElaoVoucherAuthenticationExtension extends Extension
{
    /**
     * Cache provider Id
     */
    const CACHE_PROVIDER_ID = 'elao_voucher_authentication.voucher_provider.cache';

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.xml');

        $voucherProviderId = $config['voucher_provider'];

        if (static::CACHE_PROVIDER_ID == $voucherProviderId) {
            $loader->load('cache_voucher_provider.xml');

            if (!$cacheId = $config['voucher_provider_cache']) {
                $cacheId = 'elao_voucher_authentication.voucher_provider_cache.file_system';
                $definition = new Definition('Symfony\Component\Cache\Adapter\FilesystemAdapter', ['vouchers']);
                $container->setDefinition($cacheId, $definition);
            }

            $container
                ->getDefinition(static::CACHE_PROVIDER_ID)
                ->replaceArgument(0, new Reference($cacheId));
        }

        $container->setAlias('elao_voucher_authentication.voucher_provider.default', $voucherProviderId);
    }
}
