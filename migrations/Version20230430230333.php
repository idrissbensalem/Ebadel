<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430230333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (nom_c VARCHAR(255) NOT NULL, id_c VARCHAR(255) NOT NULL, PRIMARY KEY(nom_c)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (nom_m VARCHAR(100) NOT NULL, nom_s_c VARCHAR(255) DEFAULT NULL, nom_c VARCHAR(255) DEFAULT NULL, id_m VARCHAR(255) NOT NULL, INDEX IDX_5A6F91CEF2A45E31 (nom_s_c), INDEX IDX_5A6F91CE2AF2F06E (nom_c), PRIMARY KEY(nom_m)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie (nom_s_c VARCHAR(255) NOT NULL, nom_c VARCHAR(255) DEFAULT NULL, id_s_c VARCHAR(255) NOT NULL, INDEX IDX_6FF3A7012AF2F06E (nom_c), PRIMARY KEY(nom_s_c)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CEF2A45E31 FOREIGN KEY (nom_s_c) REFERENCES souscategorie (nom_s_c)');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CE2AF2F06E FOREIGN KEY (nom_c) REFERENCES categorie (nom_c)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT FK_6FF3A7012AF2F06E FOREIGN KEY (nom_c) REFERENCES categorie (nom_c)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CEF2A45E31');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CE2AF2F06E');
        $this->addSql('ALTER TABLE souscategorie DROP FOREIGN KEY FK_6FF3A7012AF2F06E');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE souscategorie');
    }
}
