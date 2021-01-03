<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201227174627 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table to keep page token from previous operation.';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE library_pointer (
            id INT AUTO_INCREMENT NOT NULL, 
            page_token TEXT, 
            created_at DATETIME NOT NULL, 
            status VARCHAR(64) NOT NULL, 
            PRIMARY KEY(id)) 
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE library_pointer');
    }
}
