<?php

namespace App\Command;

use App\Repository\ReservationRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:remove-expired-reservation',
    description: 'Add a short description for your command',
)]
class RemoveExpiredReservationCommand extends Command
{
    public function __construct( private ReservationRepository $reservationRepository)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->note('Removing old reservations: start');
        $cnt = $this->reservationRepository->deleteByValidDate();
        $io->success(sprintf('Removed: %d reservation(s)', $cnt));

        return Command::SUCCESS;
    }
}
