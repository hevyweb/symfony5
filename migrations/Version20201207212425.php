<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201207212425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Make download time null.';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE image ADD locked_at DATETIME');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE DROP COLUMN locked_at');
    }
}
