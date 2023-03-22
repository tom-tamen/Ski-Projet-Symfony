<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230322140819 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, img_url VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faq (id INT AUTO_INCREMENT NOT NULL, station_id INT DEFAULT NULL, question LONGTEXT NOT NULL, answer LONGTEXT NOT NULL, INDEX IDX_E8FF75CC21BDB235 (station_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE faq ADD CONSTRAINT FK_E8FF75CC21BDB235 FOREIGN KEY (station_id) REFERENCES station (id)');
        $this->addSql('ALTER TABLE lift ADD duration TIME NOT NULL, ADD grade DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE slope ADD grade DOUBLE PRECISION NOT NULL, ADD duration TIME NOT NULL, ADD people INT NOT NULL, ADD quality VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE faq DROP FOREIGN KEY FK_E8FF75CC21BDB235');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE faq');
        $this->addSql('ALTER TABLE lift DROP duration, DROP grade');
        $this->addSql('ALTER TABLE slope DROP grade, DROP duration, DROP people, DROP quality');
    }
}
