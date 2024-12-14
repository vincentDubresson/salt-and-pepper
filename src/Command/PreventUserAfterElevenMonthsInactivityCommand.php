<?php

namespace App\Command;

use App\Mailer\Mailer;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'sap:prevent-user-after-eleven-months-inactivity',
    description: 'Prevent users from account deletion after eleven months of inactivity'
)]
class PreventUserAfterElevenMonthsInactivityCommand extends Command
{
    use LockableTrait;

    private const MONTHS_NUMBER = 11;

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly Mailer $mailer,

    ) {
        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln(['sap:prevent-user-after-eleven-months-inactivity', '']);

        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        $inactiveUsersSinceTwelveMonths = $this->userRepository->getAllInactiveWithoutAdminsSinceXMonths(self::MONTHS_NUMBER);

        if (empty($inactiveUsersSinceTwelveMonths)) {
            $output->writeln('No inactive users found.');

            return Command::SUCCESS;
        }

        $users = [];

        foreach ($inactiveUsersSinceTwelveMonths as $user) {
            $users[] = [
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname(),
                'email' => $user->getEmail(),
            ];
        }

        foreach ($users as $user) {
            $this->mailer->sendPreventUserFromAccountRemovalForInactivity($user['firstname'], $user['lastname'], $user['email']);
        }

        $this->release();

        $output->writeln(['', 'Command succeeded']);

        return Command::SUCCESS;
    }
}
