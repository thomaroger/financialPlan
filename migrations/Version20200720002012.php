<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200720002012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forecast_money_expense ADD thrift_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE forecast_money_expense ADD CONSTRAINT FK_5305340E776B0BED FOREIGN KEY (thrift_id) REFERENCES thrift (id)');
        $this->addSql('CREATE INDEX IDX_5305340E776B0BED ON forecast_money_expense (thrift_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE forecast_money_expense DROP FOREIGN KEY FK_5305340E776B0BED');
        $this->addSql('DROP INDEX IDX_5305340E776B0BED ON forecast_money_expense');
        $this->addSql('ALTER TABLE forecast_money_expense DROP thrift_id');
    }
}
