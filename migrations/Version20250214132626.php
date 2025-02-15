<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250214132626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE crypto_rate (id INT AUTO_INCREMENT NOT NULL, cryptocurrency_id INT DEFAULT NULL, currency_id INT DEFAULT NULL, rate DOUBLE PRECISION NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_53301E6583FC03A (cryptocurrency_id), INDEX IDX_53301E638248176 (currency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cryptocurrency (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(120) NOT NULL, symbol VARCHAR(120) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE currency (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(120) DEFAULT NULL, symbol VARCHAR(120) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE crypto_rate ADD CONSTRAINT FK_53301E6583FC03A FOREIGN KEY (cryptocurrency_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE crypto_rate ADD CONSTRAINT FK_53301E638248176 FOREIGN KEY (currency_id) REFERENCES currency (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE crypto_rate DROP FOREIGN KEY FK_53301E6583FC03A');
        $this->addSql('ALTER TABLE crypto_rate DROP FOREIGN KEY FK_53301E638248176');
        $this->addSql('DROP TABLE crypto_rate');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('DROP TABLE currency');
    }
}
