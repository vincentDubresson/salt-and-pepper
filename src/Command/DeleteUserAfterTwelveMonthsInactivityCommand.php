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
    name: 'sap:delete-user-after-twelve-months-inactivity',
    description: 'Deletes users after twelve months of inactivity'
)]
class DeleteUserAfterTwelveMonthsInactivityCommand extends Command
{
    use LockableTrait;

    private const MONTHS_NUMBER = 12;

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
        $output->writeln(['sap:delete-user-after-twelve-months-inactivity', '']);

        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return Command::FAILURE;
        }

        $inactiveUsersSinceTwelveMonths = $this->userRepository->getAllInactiveWithoutAdminsSinceXMonths(self::MONTHS_NUMBER);

        if (empty($inactiveUsersSinceTwelveMonths)) {
            $output->writeln('No inactive users found.');

            return Command::SUCCESS;
        }

        $deletedUsers = [];

        foreach ($inactiveUsersSinceTwelveMonths as $user) {
            try {
                $this->userRepository->remove($user, true);

                $deletedUsers[] = [
                    'firstname' => $user->getFirstname(),
                    'lastname' => $user->getLastname(),
                    'email' => $user->getEmail(),
                ];

                $output->writeln(sprintf('Deleted user %s %s - %s.', $user->getFirstname(), $user->getLastname(), $user->getEmail()));
            } catch (\Exception $e) {
                $output->writeln(sprintf('An error occurred while trying to delete user %s %s - %s : %s.', $user->getFirstname(), $user->getLastname(), $user->getEmail(), $e->getMessage()));
            }
        }

        if (!empty($deletedUsers)) {
            foreach ($deletedUsers as $user) {
                $this->mailer->sendRemovedAccountForInactivity($user['firstname'], $user['lastname'], $user['email']);
            }

            $this->mailer->sendReportRemovedAccountForInactivity($deletedUsers);
        }

        $this->release();

        $output->writeln(['', 'Command succeeded']);

        return Command::SUCCESS;
    }
}
