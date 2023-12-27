<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227211615 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campaign_run_log (id INT NOT NULL, campaign_id INT NOT NULL, run_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, complete_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D0DC792DF639F774 ON campaign_run_log (campaign_id)');
        $this->addSql('ALTER TABLE campaign_run_log ADD CONSTRAINT FK_D0DC792DF639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE campaign_contact ADD CONSTRAINT FK_E4D87A14F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign_run_log (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE campaign_contact DROP CONSTRAINT FK_E4D87A14F639F774');
        $this->addSql('ALTER TABLE campaign_run_log DROP CONSTRAINT FK_D0DC792DF639F774');
        $this->addSql('DROP TABLE campaign_run_log');
    }
}
