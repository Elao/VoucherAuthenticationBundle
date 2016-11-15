<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle;

use Elao\Bundle\VoucherAuthenticationBundle\Security\Factory\VoucherFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ElaoVoucherAuthenticationBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new VoucherFactory());
    }
}
