<?php

namespace Elao\Bundle\VoucherAuthenticationBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Elao\Bundle\VoucherAuthenticationBundle\Voucher\Voucher;

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
            ->addOption('ttl', 't', InputOption::VALUE_REQUIRED, 'Time to live', '+15 minutes')
        ;
    }

    /**
     * {@inhertidoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $voucher = new Voucher(
            $input->getArgument('username'),
            $input->getOption('ttl')
        );

        if (!$this->getVoucherProvider()->persist($voucher)) {
            return $output->writeln(sprintf('<error>%s</error>', 'Token could not be saved.'));
        }

        $output->writeln(sprintf(
            'Authentication voucher for user <info>%s</info>:%s<comment>%s</comment>',
            $voucher->getUsername(),
            PHP_EOL,
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
