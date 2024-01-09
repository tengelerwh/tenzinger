<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109135454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add data';
    }

    public function up(Schema $schema): void
    {
        $employees = [
            ['047ce444-607e-4bfb-aecc-11a7d0b11992', '0005', 'Arnout', 'car', 15, 3.5],
            ['09c80bc7-a714-424b-b3be-ae3f789a6fd1', '0008', 'Ahmed', 'car', 45, 4],
            ['0a615963-318a-4123-8d14-048aef41af31', '0007', 'Rens', 'bike', 5, 5],
            ['318d9e6e-725c-46f3-881c-2712d9de1cd6', '0001', 'Paul', 'train', 27, 4],
            ['620c7c1e-7140-4ccb-9f1f-9b598431403f', '0004', 'Tineke', 'bike', 9, 4],
            ['79ba380f-51bf-4f36-a5b0-9dc856c14911', '0002', 'Martin', 'bus', 12, 2.5],
            ['c42cf32b-ba94-4bbf-aa6a-d64fa5011ec0', '0006', 'Matthijs', 'bike', 3, 5],
            ['e6bd2bf6-37c3-4570-ac9e-7e1966dcc66c', '0003', 'Jeroen', 'car', 35, 4],
        ];

        foreach($employees as $row) {
            $this->addSql('INSERT INTO `employee` (`guid`, `employee_id`, `name`, `transport_type`, `commute_distance`, `work_days_per_week`) VALUES (?, ?, ?, ?, ?, ?);', $row);
        }

        $amounts = [
            ['87dde968-6564-41fb-ac97-c6ce7d8bd59f', 'car', 0, null, 0.10],
            ['7c4349b3-4622-4fef-a685-3255df386561', 'bus', 0, null, 0.25],
            ['bf80fe55-0353-472d-b42f-b9eb633f0208', 'train', 0, null, 0.25],
            ['af10878f-4bd7-43b2-89f0-cd1081995baa', 'bike', 0, 5, 0.50],
            ['b8d75829-36e9-4b19-9938-bb3e81c4b47f', 'bike', 5, 10, 1.00],
        ];
        foreach($amounts as $row) {
            $this->addSql('INSERT INTO `compensation_amount` (`guid`, `transport_type`, `min_distance`, `max_distance`, `amount`) VALUES (?, ?, ?, ?, ?);', $row);
        }

        $compensations = [
            ['5e2ca23d-138d-43d2-bfaf-9a3014c6743b', '0001', 2024, 1, 'car', 18, 18 * 27, 18 * 27 * 0.10],
        ];
        foreach($compensations as $row) {
            $this->addSql('INSERT INTO `commute_compensation` (`guid`, `employee_id`, `year`, `month`,`transport_type`, `nr_of_days`, `total_distance`, `compensation_amount`) VALUES (?, ?, ?, ?, ?, ?, ?, ?);', $row);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM `employee`;');
        $this->addSql('DELETE FROM `compensation_amount`;');
        $this->addSql('DELETE FROM `commute_compensation`;');
    }
}
