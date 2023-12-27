<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227230854 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE campaign_contact (id INT NOT NULL, campaign_id INT NOT NULL, contact_id INT NOT NULL, is_sms_sent BOOLEAN DEFAULT NULL, is_email_sent BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E4D87A14F639F774 ON campaign_contact (campaign_id)');
        $this->addSql('CREATE INDEX IDX_E4D87A14E7A1254A ON campaign_contact (contact_id)');
        $this->addSql('ALTER TABLE campaign_contact ADD CONSTRAINT FK_E4D87A14F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign_run_log (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE campaign_contact ADD CONSTRAINT FK_E4D87A14E7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE campaign_contact DROP CONSTRAINT FK_E4D87A14F639F774');
        $this->addSql('ALTER TABLE campaign_contact DROP CONSTRAINT FK_E4D87A14E7A1254A');
        $this->addSql('DROP TABLE campaign_contact');
    }
}
