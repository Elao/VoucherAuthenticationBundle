<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Voucher factory
 */
class VoucherFactory extends AbstractFactory
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addOption('login_path', 'voucher');
        $this->addOption('check_path', 'voucher');
        $this->addOption('token_parameter', 'token');

        $this->defaultSuccessHandlerOptions['target_paths'] = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getPosition()
    {
        return 'pre_auth';
    }

    /**
     * {@inheritdoc}
     */
    public function getKey()
    {
        return 'voucher';
    }

    /**
     * {@inheritdoc}
     */
    protected function getListenerId()
    {
        return 'security.authentication.listener.voucher';
    }

    /**
     * {@inheritdoc}
     */
    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $providerId = 'security.authentication.provider.voucher.' . $id;

        $container
            ->setDefinition($providerId, new DefinitionDecorator('security.authentication.provider.voucher'))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(1, new Reference($config['voucher_provider']))
        ;

        return $providerId;
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node->children()
            ->scalarNode('voucher_provider')
                ->cannotBeEmpty()
                ->defaultValue('elao_voucher_authentication.voucher_provider.default')
            ->end()
            ->scalarNode('success_handler')
                ->defaultValue('elao_voucher_authentication.success_handler.intent')
            ->end()
            ->arrayNode('target_paths')
                ->useAttributeAsKey('intent')
                ->prototype('array')
                    ->beforeNormalization()
                        ->ifString()
                        ->then(function ($value) { return ['path' => $value]; })
                    ->end()
                    ->children()
                        ->scalarNode('intent')
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('path')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}
