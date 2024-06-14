<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611054525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_image (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, url VARCHAR(255) NOT NULL, alt VARCHAR(255) NOT NULL, INDEX IDX_6C4FE9B8ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_image ADD CONSTRAINT FK_6C4FE9B8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE provider ADD approved TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_image DROP FOREIGN KEY FK_6C4FE9B8ED5CA9E6');
        $this->addSql('DROP TABLE service_image');
        $this->addSql('ALTER TABLE provider DROP approved');
    }
}
