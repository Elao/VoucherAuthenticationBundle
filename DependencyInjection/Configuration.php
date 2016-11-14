<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('elao_voucher_authentication');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('voucher_provider')
                    ->info('Default voucher provider (service implementing VoucherProviderInterface).')
                    ->cannotBeEmpty()
                    ->defaultValue('elao_voucher_authentication.voucher_provider.cache')
                ->end()
                ->scalarNode('voucher_provider_cache')
                    ->info('Cache system for CacheVoucherProvider (only needed if you use the default Voucher Provider).')
                    ->defaultNull()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
