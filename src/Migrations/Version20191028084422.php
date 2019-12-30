<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028084422 extends AbstractMigration
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

        $this->addSql('DROP TABLE product_db');
        $this->addSql('ALTER TABLE product ADD category VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE product_category ADD category VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('CREATE TABLE product_db (id INT AUTO_INCREMENT NOT NULL, 
                name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, 
                description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, 
                date_of_creation DATETIME NOT NULL, 
                date_of_last_modification DATETIME NOT NULL, 
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product DROP category');
        $this->addSql('ALTER TABLE product_category DROP category');
    }
}
