<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241128202035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `recipe` (id INT AUTO_INCREMENT NOT NULL, subcategory_id INT NOT NULL, cooking_type_id INT NOT NULL, difficulty_id INT NOT NULL, cost_id INT NOT NULL, user_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, serving_number INT NOT NULL, preparation_time TIME NOT NULL, cooking_time TIME NOT NULL, resting_time TIME NOT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_DA88B1375DC6FE57 (subcategory_id), INDEX IDX_DA88B1372609125B (cooking_type_id), INDEX IDX_DA88B137FCFA9DAE (difficulty_id), INDEX IDX_DA88B1371DBF857F (cost_id), INDEX IDX_DA88B137A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B1375DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES `subcategory` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B1372609125B FOREIGN KEY (cooking_type_id) REFERENCES `cooking_type` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B137FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES `difficulty` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B1371DBF857F FOREIGN KEY (cost_id) REFERENCES `cost` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B137A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B1375DC6FE57');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B1372609125B');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B137FCFA9DAE');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B1371DBF857F');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B137A76ED395');
        $this->addSql('DROP TABLE `recipe`');
    }
}
