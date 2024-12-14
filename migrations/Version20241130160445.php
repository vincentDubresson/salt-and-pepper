<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241130160445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `recipes_ingredients` (id INT AUTO_INCREMENT NOT NULL, unit_id INT NOT NULL, ingredient_id INT NOT NULL, recipe_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, sort DOUBLE PRECISION NOT NULL, INDEX IDX_761206B0F8BD700D (unit_id), INDEX IDX_761206B0933FE08C (ingredient_id), INDEX IDX_761206B059D8A214 (recipe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `recipes_ingredients` ADD CONSTRAINT FK_761206B0F8BD700D FOREIGN KEY (unit_id) REFERENCES `unit` (id)');
        $this->addSql('ALTER TABLE `recipes_ingredients` ADD CONSTRAINT FK_761206B0933FE08C FOREIGN KEY (ingredient_id) REFERENCES `ingredient` (id)');
        $this->addSql('ALTER TABLE `recipes_ingredients` ADD CONSTRAINT FK_761206B059D8A214 FOREIGN KEY (recipe_id) REFERENCES `recipe` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1371DBF857F');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1372609125B');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B1375DC6FE57');
        $this->addSql('ALTER TABLE recipe DROP FOREIGN KEY FK_DA88B137FCFA9DAE');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1371DBF857F FOREIGN KEY (cost_id) REFERENCES `cost` (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1372609125B FOREIGN KEY (cooking_type_id) REFERENCES `cooking_type` (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B1375DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES `subcategory` (id)');
        $this->addSql('ALTER TABLE recipe ADD CONSTRAINT FK_DA88B137FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES `difficulty` (id)');
        $this->addSql('ALTER TABLE subcategory DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('ALTER TABLE subcategory ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES `category` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `recipes_ingredients` DROP FOREIGN KEY FK_761206B0F8BD700D');
        $this->addSql('ALTER TABLE `recipes_ingredients` DROP FOREIGN KEY FK_761206B0933FE08C');
        $this->addSql('ALTER TABLE `recipes_ingredients` DROP FOREIGN KEY FK_761206B059D8A214');
        $this->addSql('DROP TABLE `recipes_ingredients`');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B1375DC6FE57');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B1372609125B');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B137FCFA9DAE');
        $this->addSql('ALTER TABLE `recipe` DROP FOREIGN KEY FK_DA88B1371DBF857F');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B1375DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategory (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B1372609125B FOREIGN KEY (cooking_type_id) REFERENCES cooking_type (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B137FCFA9DAE FOREIGN KEY (difficulty_id) REFERENCES difficulty (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `recipe` ADD CONSTRAINT FK_DA88B1371DBF857F FOREIGN KEY (cost_id) REFERENCES cost (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `subcategory` DROP FOREIGN KEY FK_DDCA44812469DE2');
        $this->addSql('ALTER TABLE `subcategory` ADD CONSTRAINT FK_DDCA44812469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
