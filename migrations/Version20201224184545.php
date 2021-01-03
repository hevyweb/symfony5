<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224184545 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add column for local path and a column for processed time.';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE image ADD local_path varchar(255)');
        $this->addSql('ALTER TABLE image ADD processed_at DATETIME');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE DROP COLUMN local_path');
        $this->addSql('ALTER TABLE DROP COLUMN processed_at');
    }
}
