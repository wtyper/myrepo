<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191106084727 extends AbstractMigration
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

        $this->addSql('ALTER TABLE book CHANGE genre_id genres_id INT NOT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3316A3B2603 
                        FOREIGN KEY (genres_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3316A3B2603 ON book (genres_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(
            $this->connection->getDatabasePlatform()->getName() !== 'mysql',
            'Migration can only be executed safely on \'mysql\'.'
        );

        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3316A3B2603');
        $this->addSql('DROP INDEX IDX_CBE5A3316A3B2603 ON book');
        $this->addSql('ALTER TABLE book CHANGE genres_id genre_id INT NOT NULL');
    }
}
