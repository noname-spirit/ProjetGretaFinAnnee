<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507204523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_blog ADD image_data LONGBLOB DEFAULT NULL, ADD image_mime_type VARCHAR(100) DEFAULT NULL, DROP sous_titre, DROP image, CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE contenue contenu LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_blog ADD sous_titre VARCHAR(50) NOT NULL, ADD image VARCHAR(255) DEFAULT NULL, DROP image_data, DROP image_mime_type, CHANGE titre titre VARCHAR(50) NOT NULL, CHANGE contenu contenue LONGTEXT NOT NULL');
    }
}
