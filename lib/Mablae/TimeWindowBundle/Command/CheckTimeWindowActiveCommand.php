<?php
namespace Mablae\TimeWindowBundle\Command;


use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CheckTimeWindowActiveCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('time-window:check')
            ->setDescription('Check if a named time-window is active')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the time window');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $name = $input->getArgument('name');
        $timeWindowService = $this->getContainer()->get('mablae_time_window.service');
        $result = $timeWindowService->isTimeWindowActive($name);

        $io = new SymfonyStyle($input, $output);
        if ($result == true) {
            $io->success("The time window '$name' is active!");
        } else {
            $io->warning("The time window '$name' is NOT active!");
        }
    }
}