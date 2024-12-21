<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241221180426 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `recipes_comments` (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, user_id INT NOT NULL, comment LONGTEXT NOT NULL, enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_33FE1EF259D8A214 (recipe_id), INDEX IDX_33FE1EF2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `recipes_comments` ADD CONSTRAINT FK_33FE1EF259D8A214 FOREIGN KEY (recipe_id) REFERENCES `recipe` (id)');
        $this->addSql('ALTER TABLE `recipes_comments` ADD CONSTRAINT FK_33FE1EF2A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE unit CHANGE pluralizable pluralizable TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `recipes_comments` DROP FOREIGN KEY FK_33FE1EF259D8A214');
        $this->addSql('ALTER TABLE `recipes_comments` DROP FOREIGN KEY FK_33FE1EF2A76ED395');
        $this->addSql('DROP TABLE `recipes_comments`');
        $this->addSql('ALTER TABLE `unit` CHANGE pluralizable pluralizable TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
