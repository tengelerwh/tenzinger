<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240108162011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $data = [
            ['047ce444-607e-4bfb-aecc-11a7d0b11992', 'Arnout', '0005'],
            ['09c80bc7-a714-424b-b3be-ae3f789a6fd1', 'Ahmed', '0008'],
            ['0a615963-318a-4123-8d14-048aef41af31', 'Rens', '0007'],
            ['318d9e6e-725c-46f3-881c-2712d9de1cd6', 'Paul', '0001'],
            ['620c7c1e-7140-4ccb-9f1f-9b598431403f', 'Tineke', '0004'],
            ['79ba380f-51bf-4f36-a5b0-9dc856c14911', 'Martin', '0002'],
            ['c42cf32b-ba94-4bbf-aa6a-d64fa5011ec0', 'Matthijs', '0006'],
            ['e6bd2bf6-37c3-4570-ac9e-7e1966dcc66c', 'Jeroen', '0003'],
        ];

        foreach($data as $row) {
            $this->addSql('INSERT INTO `employee` (`guid`, `name`, `employee_id`) VALUES (?, ?, ?);', $row);
        }
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM `employee`;');
    }
}
