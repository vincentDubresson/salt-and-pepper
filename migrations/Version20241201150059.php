<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201150059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `recipe_image` (id INT AUTO_INCREMENT NOT NULL, recipe_id INT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, sort DOUBLE PRECISION NOT NULL, INDEX IDX_D32ED04059D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `recipe_image` ADD CONSTRAINT FK_D32ED04059D8A214 FOREIGN KEY (recipe_id) REFERENCES `recipe` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `recipe_image` DROP FOREIGN KEY FK_D32ED04059D8A214');
        $this->addSql('DROP TABLE `recipe_image`');
    }
}
