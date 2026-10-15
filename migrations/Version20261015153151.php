<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261015153151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Use the minimum stat value as the default for new trainers.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dresseur CHANGE str str INT DEFAULT 1 NOT NULL, CHANGE dex dex INT DEFAULT 1 NOT NULL, CHANGE con con INT DEFAULT 1 NOT NULL, CHANGE end end INT DEFAULT 1 NOT NULL, CHANGE vol vol INT DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dresseur CHANGE str str INT DEFAULT 0 NOT NULL, CHANGE dex dex INT DEFAULT 0 NOT NULL, CHANGE con con INT DEFAULT 0 NOT NULL, CHANGE end end INT DEFAULT 0 NOT NULL, CHANGE vol vol INT DEFAULT 0 NOT NULL');
    }
}
