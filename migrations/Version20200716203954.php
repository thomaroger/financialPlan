<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716203954 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forecast_money_expense (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, recurrent TINYINT(1) NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forecast_money_expense_instance (id INT AUTO_INCREMENT NOT NULL, forecast_money_expense_id INT DEFAULT NULL, price DOUBLE PRECISION NOT NULL, month INT NOT NULL, year INT DEFAULT NULL, INDEX IDX_7D972755A79FEF11 (forecast_money_expense_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forecast_money_expense_instance ADD CONSTRAINT FK_7D972755A79FEF11 FOREIGN KEY (forecast_money_expense_id) REFERENCES forecast_money_expense (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forecast_money_expense_instance DROP FOREIGN KEY FK_7D972755A79FEF11');
        $this->addSql('DROP TABLE forecast_money_expense');
        $this->addSql('DROP TABLE forecast_money_expense_instance');
    }
}
