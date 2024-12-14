<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116181444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `city` (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, postal_code VARCHAR(5) NOT NULL, city_code VARCHAR(5) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `country` (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, address1 VARCHAR(255) DEFAULT NULL, address2 VARCHAR(255) DEFAULT NULL, city_id INT DEFAULT NULL, country_id INT DEFAULT NULL, enabled TINYINT(1) NOT NULL, slug VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_8D93D6498BAC62AF (city_id), INDEX IDX_8D93D649F92F3E70 (country_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6498BAC62AF FOREIGN KEY (city_id) REFERENCES `city` (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D649F92F3E70 FOREIGN KEY (country_id) REFERENCES `country` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6498BAC62AF');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F92F3E70');
        $this->addSql('DROP TABLE `city`');
        $this->addSql('DROP TABLE `country`');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE `user`');
    }
}
