<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Creates providers and provider_types tables and their relationship
 */
final class Version20231029085818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates providers and provider_types tables and their relationship';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE provider_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE providers (id INT AUTO_INCREMENT NOT NULL, provider_type_id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(50) NOT NULL, active TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_E225D41735142E34 (provider_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE providers ADD CONSTRAINT FK_E225D41735142E34 FOREIGN KEY (provider_type_id) REFERENCES provider_types (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE providers DROP FOREIGN KEY FK_E225D41735142E34');
        $this->addSql('DROP TABLE provider_types');
        $this->addSql('DROP TABLE providers');
    }
}
