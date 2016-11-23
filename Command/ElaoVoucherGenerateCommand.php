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

use Elao\Bundle\VoucherAuthenticationBundle\Voucher\DisposableAuthenticationVoucher;
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
            ->setName('voucher:generate:authentication')
            ->setDescription('Generate a disposable authentication voucher for the given username')
            ->addArgument('username', InputArgument::REQUIRED, 'The username')
            ->addArgument('ttl', InputArgument::OPTIONAL, 'The time-to-live', '+15 minutes')
        ;
    }

    /**
     * {@inhertidoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $voucher = new DisposableAuthenticationVoucher(
            $input->getArgument('username'),
            $input->getArgument('ttl')
        );

        if (!$this->getVoucherProvider()->persist($voucher)) {
            return $output->writeln(sprintf('<error>%s</error>', 'Token could not be saved.'));
        }

        $output->writeln(sprintf(
            'Authentication voucher for user <info>%s</info> with expiration on <comment>%s</comment>: %s',
            $voucher->getUsername(),
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
