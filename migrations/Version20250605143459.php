<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250605143459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_blog ADD image LONGBLOB DEFAULT NULL, DROP image_name, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC37323A20');
        $this->addSql('DROP INDEX IDX_67F068BC37323A20 ON commentaire');
        $this->addSql('ALTER TABLE commentaire ADD type VARCHAR(255) NOT NULL, DROP article_blog_id, DROP created_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_blog ADD image_name VARCHAR(255) DEFAULT NULL, DROP image, CHANGE content content LONGTEXT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commentaire ADD article_blog_id INT NOT NULL, ADD created_at DATETIME NOT NULL, DROP type');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC37323A20 FOREIGN KEY (article_blog_id) REFERENCES article_blog (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_67F068BC37323A20 ON commentaire (article_blog_id)');
    }
}
