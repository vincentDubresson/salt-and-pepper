<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241215181437 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipe_user_favorites (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_961E7F8259D8A214 (recipe_id), INDEX IDX_961E7F82A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recipe_user_favorites ADD CONSTRAINT FK_961E7F8259D8A214 FOREIGN KEY (recipe_id) REFERENCES `recipe` (id)');
        $this->addSql('ALTER TABLE recipe_user_favorites ADD CONSTRAINT FK_961E7F82A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recipe_user_favorites DROP FOREIGN KEY FK_961E7F8259D8A214');
        $this->addSql('ALTER TABLE recipe_user_favorites DROP FOREIGN KEY FK_961E7F82A76ED395');
        $this->addSql('DROP TABLE recipe_user_favorites');
    }
}
