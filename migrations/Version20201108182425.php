<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201108182425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image (
            id INT AUTO_INCREMENT NOT NULL, 
            filename VARCHAR(255) NOT NULL, 
            path text NOT NULL, 
            created_at DATETIME NOT NULL, 
            downloaded_at DATETIME NOT NULL, 
            type VARCHAR(255) NOT NULL, 
            camera_make VARCHAR(255) DEFAULT NULL, 
            camera_model VARCHAR(255) DEFAULT NULL, 
            focal_length DOUBLE PRECISION DEFAULT NULL, 
            aperture_fnumber DOUBLE PRECISION DEFAULT NULL, 
            iso_equivalent INT DEFAULT NULL, 
            width INT NOT NULL, 
            height INT NOT NULL, 
            description LONGTEXT DEFAULT NULL, 
            PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE image');
    }
}
