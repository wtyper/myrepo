<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191107134718 extends AbstractMigration
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

        $this->addSql('ALTER TABLE author CHANGE date_of_birth date_of_birth DATETIME NOT NULL, 
                        CHANGE date_of_death date_of_death DATETIME NOT NULL');
        $this->addSql('ALTER TABLE book CHANGE year_of_publishment year_of_publishment DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE author CHANGE date_of_birth date_of_birth INT NOT NULL, 
                        CHANGE date_of_death date_of_death INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book CHANGE year_of_publishment year_of_publishment INT NOT NULL');
    }
}
