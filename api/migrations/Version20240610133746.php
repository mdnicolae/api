<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240610133746 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE provider (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, iban VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, cif VARCHAR(255) DEFAULT NULL, services_count INT DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_92C4739C989D9B62 (slug), UNIQUE INDEX UNIQ_92C4739CE7927C74 (email), UNIQUE INDEX UNIQ_92C4739C444F97DD (phone), UNIQUE INDEX UNIQ_92C4739CFAD56E62 (iban), UNIQUE INDEX UNIQ_92C4739CA53EB8E8 (cif), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, provider_id INT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, city VARCHAR(255) NOT NULL, duration_minutes INT NOT NULL, UNIQUE INDEX UNIQ_E19D9AD2989D9B62 (slug), INDEX IDX_E19D9AD2A53A8AA (provider_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A53A8AA');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE service');
    }
}
