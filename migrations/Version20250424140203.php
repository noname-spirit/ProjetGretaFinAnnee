<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250424140203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ADD nom VARCHAR(255) NOT NULL, DROP salarier, DROP entrepreneur, DROP etufiant, DROP autre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ADD entrepreneur VARCHAR(255) NOT NULL, ADD etufiant VARCHAR(255) NOT NULL, ADD autre VARCHAR(255) NOT NULL, CHANGE nom salarier VARCHAR(255) NOT NULL');
    }
}
