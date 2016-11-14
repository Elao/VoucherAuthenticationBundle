<?php

namespace Elao\Bundle\VoucherAuthenticationBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Elao\Bundle\VoucherAuthenticationBundle\Security\Factory\VoucherFactory;

class ElaoVoucherAuthenticationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new VoucherFactory());
    }
}
