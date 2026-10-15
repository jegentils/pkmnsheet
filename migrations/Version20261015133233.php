<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261015133233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Pokemon records associated with trainers.';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE pkmn (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(20) DEFAULT NULL, name VARCHAR(100) NOT NULL, number INT NOT NULL, iv_str INT DEFAULT 0 NOT NULL, iv_dex INT DEFAULT 0 NOT NULL, iv_con INT DEFAULT 0 NOT NULL, iv_end INT DEFAULT 0 NOT NULL, iv_vol INT DEFAULT 0 NOT NULL, ev_str INT DEFAULT 0 NOT NULL, ev_dex INT DEFAULT 0 NOT NULL, ev_con INT DEFAULT 0 NOT NULL, ev_end INT DEFAULT 0 NOT NULL, ev_vol INT DEFAULT 0 NOT NULL, vit_temp INT DEFAULT 0 NOT NULL, affection INT DEFAULT 0 NOT NULL, nature VARCHAR(50) DEFAULT NULL, xp INT DEFAULT 0 NOT NULL, soumission TINYINT DEFAULT 0 NOT NULL, held_item VARCHAR(100) DEFAULT NULL, talent VARCHAR(100) DEFAULT NULL, dresseur_id INT NOT NULL, INDEX IDX_74A002F4A1A01CBE (dresseur_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE pkmn ADD CONSTRAINT FK_74A002F4A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES dresseur (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pkmn DROP FOREIGN KEY FK_74A002F4A1A01CBE');
        $this->addSql('DROP TABLE pkmn');
    }
}
