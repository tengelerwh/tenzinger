<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240109130430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE commute_compensation (guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', employee_id TINYTEXT NOT NULL, year INT NOT NULL, month INT NOT NULL, transport_type TINYTEXT NOT NULL, nr_of_days INT NOT NULL, total_distance INT NOT NULL, compensation_amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(guid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compensation_amount (guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', transport_type TINYTEXT NOT NULL, min_distance INT NOT NULL, max_distance INT NULL, amount DOUBLE PRECISION NOT NULL, PRIMARY KEY(guid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (guid CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', employee_id TINYTEXT NOT NULL, name TINYTEXT NOT NULL, transport_type TINYTEXT NOT NULL, commute_distance INT NOT NULL, work_days_per_week DOUBLE PRECISION NOT NULL, PRIMARY KEY(guid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE commute_compensation');
        $this->addSql('DROP TABLE compensation_amount');
        $this->addSql('DROP TABLE employee');
    }
}
