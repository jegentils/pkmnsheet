<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20261015132505 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dresseur (id INT AUTO_INCREMENT NOT NULL, genre VARCHAR(20) DEFAULT NULL, name VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, str INT DEFAULT 0 NOT NULL, dex INT DEFAULT 0 NOT NULL, con INT DEFAULT 0 NOT NULL, end INT DEFAULT 0 NOT NULL, vol INT DEFAULT 0 NOT NULL, str_temp INT DEFAULT 0 NOT NULL, dex_temp INT DEFAULT 0 NOT NULL, con_temp INT DEFAULT 0 NOT NULL, end_temp INT DEFAULT 0 NOT NULL, vol_temp INT DEFAULT 0 NOT NULL, vit_temp INT DEFAULT 0 NOT NULL, money INT DEFAULT 0 NOT NULL, nature VARCHAR(50) DEFAULT NULL, xp INT DEFAULT 0 NOT NULL, pkmn_1_id INT DEFAULT NULL, pkmn_2_id INT DEFAULT NULL, pkmn_3_id INT DEFAULT NULL, pkmn_4_id INT DEFAULT NULL, pkmn_5_id INT DEFAULT NULL, pkmn_6_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_77EA2FC6A76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE dresseur ADD CONSTRAINT FK_77EA2FC6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dresseur DROP FOREIGN KEY FK_77EA2FC6A76ED395');
        $this->addSql('DROP TABLE dresseur');
    }
}
