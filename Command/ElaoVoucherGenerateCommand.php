<?php

/*
 * This file is part of the Voucher Authentication bundle.
 *
 * Copyright © élao <contact@elao.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Elao\Bundle\VoucherAuthenticationBundle\Command;

use Elao\Bundle\VoucherAuthenticationBundle\Voucher\Voucher;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ElaoVoucherGenerateCommand extends ContainerAwareCommand
{
    /**
     * {@inhertidoc}
     */
    protected function configure()
    {
        $this
            ->setName('elao:voucher:generate')
            ->setDescription('Generate an authentication voucher for the given username')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('intent', InputArgument::OPTIONAL, 'The intent', 'authenticate')
            ->addArgument('ttl', InputArgument::OPTIONAL, 'The time-to-live', '+15 minutes')
        ;
    }

    /**
     * {@inhertidoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $voucher = new Voucher(
            $input->getArgument('username'),
            $input->getArgument('intent'),
            $input->getArgument('ttl')
        );

        if (!$this->getVoucherProvider()->persist($voucher)) {
            return $output->writeln(sprintf('<error>%s</error>', 'Token could not be saved.'));
        }

        $output->writeln(sprintf(
            'Voucher for user <info>%s</info> with intent <comment>%s</comment> and expriation on <comment>%s</comment>: %s',
            $voucher->getUsername(),
            $voucher->getIntent(),
            $voucher->getExpiration()->format('Y-m-d H:i:s'),
            $voucher->getToken()
        ));
    }

    /**
     * Get voucher provider
     *
     * @return VoucherProviderInterface
     */
    private function getVoucherProvider()
    {
        return $this->getContainer()->get('elao_voucher_authentication.voucher_provider.default');
    }
}
