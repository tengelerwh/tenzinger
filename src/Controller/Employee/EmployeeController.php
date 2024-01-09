<?php

namespace App\Controller\Employee;

use App\Application\Employee\CompensationDto;
use App\Application\Employee\EmployeeService;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    public function __construct(
        private readonly EmployeeService $employeeService,
    ) {
    }

    #[Route('/api/employees', name: 'employee-list', methods: ['GET'])]
    public function index(
    ): Response
    {
        $employees = $this->employeeService->getEmployees();

        return $this->render('employees/employee-list.html.twig', [
            'employees' => $employees,
        ]);
    }

//'/api/employees/{employeeId}/compensations/{year<d+>}/{month<d+>}/{format}',

    #[Route(
        '/api/employees/{employeeId}/compensations/{year}/{month}/{format}',
        name: 'employee-compensation',
        defaults: ['year' => 2024, 'format' => 'csv'],
        methods: ['GET']
    )]
    public function getCompensations(
        string $employeeId,
        ?int $year = 2024,
        ?int $month = null,
        ?string $format = 'csv'
    ): Response
    {
        $compensations =$this->employeeService->getCompensations($employeeId, $year, $month);

        if ('html' === $format) {
            return $this->render('employees/employee-compensations.html.twig', [
                'employeeId' => $employeeId,
                'compensations' => $compensations,
            ]);
        }

        $fileName = sprintf('%d-%d.csv', $year, $month);
        $csvData = $this->renderAsCsv($compensations);
        $csvResponse = new Response($csvData);
        $csvResponse->headers->set('Content-Type', 'text/csv');
        $csvResponse->headers->set('Content-disposition', sprintf('attachment;filename=%s', $fileName));
        return $csvResponse;
    }

    #[Route(
        '/api/employees/{employeeId}/calculate/{year}/{month}',
        name: 'employee-compensation-calculation',
        defaults: ['year' => 2024],
        methods: ['GET']
    )]
    public function calculateCompensations(string $employeeId, int $year, ?int $month = null): Response
    {
        if (null === $month) {
            $now = new DateTimeImmutable();
            $month = (int) $now->format('m');
        }
        $nrCalculated = $this->employeeService->calculateCompensations($employeeId, $year, $month);
        return new Response(sprintf('Compensation calculated for %d employees', $nrCalculated));
    }

    private function renderAsCsv(array $compensations): string
    {
        $result = '"employeeId", "Name", "Year", "Month", "Transport", "Distance", "Work days", "Amount"' . PHP_EOL;
        /** @var CompensationDto $compensation */
        foreach($compensations as $compensation) {
            $result .= sprintf(
                '%s, %s, %d, %d, %s, %d, %d, %.2f',
                    $compensation->employeeId,
                    $compensation->name,
                    $compensation->year,
                    $compensation->month,
                    $compensation->transport,
                    $compensation->totalDistance,
                    $compensation->workDays,
                    $compensation->amount,
                ) . PHP_EOL;
        }

        return $result;
    }
}
