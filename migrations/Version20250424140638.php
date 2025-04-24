<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424140638 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE new_letter_abonne ADD activite_id INT NOT NULL, DROP telephone, DROP activite');
        $this->addSql('ALTER TABLE new_letter_abonne ADD CONSTRAINT FK_2BF9394C9B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id)');
        $this->addSql('CREATE INDEX IDX_2BF9394C9B0F88B1 ON new_letter_abonne (activite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE new_letter_abonne DROP FOREIGN KEY FK_2BF9394C9B0F88B1');
        $this->addSql('DROP INDEX IDX_2BF9394C9B0F88B1 ON new_letter_abonne');
        $this->addSql('ALTER TABLE new_letter_abonne ADD telephone VARCHAR(20) NOT NULL, ADD activite VARCHAR(255) NOT NULL, DROP activite_id');
    }
}
