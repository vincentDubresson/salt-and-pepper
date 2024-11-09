<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241109163110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO `user` (`id`, `email`, `roles`, `password`, `created_at`, `updated_at`) VALUES (1, "vincent.dubresson@live.fr", \'["ROLE_ADMIN", "ROLE_USER"]\', "$2y$13$gnGS9J6O38UJncLZ5/3K3OuZgpKc/aw2E9s59r8meedvgR9GidNCW", NOW(), NOW())');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
