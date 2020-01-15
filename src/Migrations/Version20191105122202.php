<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191105122202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, 
                        name LONGTEXT NOT NULL, 
                        last_name LONGTEXT NOT NULL, 
                        origin_country VARCHAR(255) NOT NULL, 
                        date_of_birth DATETIME NOT NULL, 
                        date_of_death DATETIME DEFAULT NULL, 
                        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, 
                        title LONGTEXT NOT NULL, 
                        description LONGTEXT NOT NULL, 
                        author LONGTEXT NOT NULL, 
                        genre LONGTEXT NOT NULL, 
                        year_of_publishment DATE NOT NULL, 
                        country_of_publishment VARCHAR(255) NOT NULL, 
                        availability VARCHAR(255) NOT NULL, 
                        date_of_create DATETIME NOT NULL, 
                        date_of_update DATETIME NOT NULL, 
                        PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
    }
}
