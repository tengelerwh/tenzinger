<?php

declare(strict_types=1);

namespace App\Application\Employee;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'employee:calculate',
    description: 'Calculate Commute compensations for all employees for the given year and month',
    hidden: false
)]
class CalculateCommand extends Command
{
    public function __construct(
        private readonly EmployeeService $employeeService,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = (int) $input->getArgument('year');
        $month = (int) $input->getArgument('month');

        if ($year <= 2020 || $year > 2030) {
            $output->writeln('<error>Invalid year</error>: between 2020 and 2030');
            return Command::INVALID;
        }

        if ($month < 1 || $month > 12) {
            $output->writeln('<error>Invalid month</error>: Between 1 and 12');
            return Command::INVALID;
        }

        $nrCalculations = $this->employeeService->calculateCompensations(null, $year, $month);

        $output->writeln(sprintf('%d employees calculated for year %04d and month %02d', $nrCalculations, $year, $month));
        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('year', InputArgument::REQUIRED, 'The year to calculate')
            ->addArgument('month', InputArgument::REQUIRED, 'The month to calculate')
        ;
    }
}
