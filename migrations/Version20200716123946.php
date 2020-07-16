<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200716123946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forecast_money_entry (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, recurrent TINYINT(1) NOT NULL, date DATE NOT NULL, INDEX IDX_50DB69EDA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE forecast_money_entry_instance (id INT AUTO_INCREMENT NOT NULL, forecast_money_entry_id INT DEFAULT NULL, price TINYINT(1) NOT NULL, month INT NOT NULL, year INT DEFAULT NULL, INDEX IDX_CD6776DA62455D21 (forecast_money_entry_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE forecast_money_entry ADD CONSTRAINT FK_50DB69EDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE forecast_money_entry_instance ADD CONSTRAINT FK_CD6776DA62455D21 FOREIGN KEY (forecast_money_entry_id) REFERENCES forecast_money_entry (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forecast_money_entry_instance DROP FOREIGN KEY FK_CD6776DA62455D21');
        $this->addSql('DROP TABLE forecast_money_entry');
        $this->addSql('DROP TABLE forecast_money_entry_instance');
    }
}
