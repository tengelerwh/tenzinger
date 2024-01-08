<?php

namespace App\Controller\Employee;

use App\Application\Employee\EmployeeService;
use App\Controller\Employee\EmployeeTravelsQueryDto;
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
            'employees' => $employees
        ]);
    }

    #[Route('/api/employees/{employeeId}/travels/{format}', name: 'employee-travels', methods: ['GET', 'POST', 'PUT'])]
    public function travels(
        #[MapQueryString] EmployeeTravelsQueryDto $queryDto
    ): Response
    {
        $travels = $this->employeeService->getTravels($queryDto->employeeId);

        if ('html' === $queryDto->format) {
            return $this->render('employees/employee-travels.html.twig', [
                'employeeId' => $queryDto->employeeId,
                'travels' => $travels,
            ]);
        }

        $csvData = $this->renderAsCsv([]);
        $csvResponse = new Response($csvData);
        $csvResponse->headers->set('Content-Type', 'text/csv');
        return $csvResponse;
    }

    private function renderAsCsv(array $data): string
    {
        $result = '100,123,"test"' . PHP_EOL;
        $result .= '100,123,"test"' . PHP_EOL;
        return $result;
    }
}
