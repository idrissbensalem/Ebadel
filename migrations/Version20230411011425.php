<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411011425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY article_ibfk_1');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY article_ibfk_2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY article_ibfk_3');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY article_ibfk_4');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY marque_ibfk_2');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY marque_ibfk_1');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY offre_ibfk_1');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY offre_ibfk_2');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY produit_ibfk_1');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY produit_ibfk_2');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY produit_ibfk_3');
        $this->addSql('ALTER TABLE souscategorie DROP FOREIGN KEY souscategorie_ibfk_1');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE souscategorie');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX Idu ON article');
        $this->addSql('DROP INDEX marque ON article');
        $this->addSql('DROP INDEX categorie ON article');
        $this->addSql('DROP INDEX sous_categorie ON article');
        $this->addSql('DROP INDEX IDX_23A0E66497DD634 ON article');
        $this->addSql('ALTER TABLE article ADD periode_utilisation VARCHAR(50) NOT NULL, ADD souscategorie VARCHAR(50) NOT NULL, DROP sous_categorie, DROP Idu, DROP periode_utilistation, CHANGE nom_article nom_article VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id_c INT AUTO_INCREMENT NOT NULL, nom_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX nom_c (nom_c), PRIMARY KEY(id_c, nom_c)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE marque (id_m INT AUTO_INCREMENT NOT NULL, nom_m VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_s_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX nom_c (nom_c), INDEX nom_s_c (nom_s_c), INDEX nom_m (nom_m), PRIMARY KEY(id_m, nom_m)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre (id_offre INT AUTO_INCREMENT NOT NULL, id_article INT NOT NULL, Idu INT NOT NULL, titre VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, categorie VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, sous_categorie VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, marque VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, produit_propose VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, periode_dutilisation VARCHAR(200) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, etat_produit_propose VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, bonus VARCHAR(100) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, image TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, num_tel INT NOT NULL, INDEX Idu (Idu), INDEX id_article (id_article), PRIMARY KEY(id_offre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (id_p INT AUTO_INCREMENT NOT NULL, titre VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_s_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_m VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, prix DOUBLE PRECISION NOT NULL, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX nom_m (nom_m), INDEX nom_s_c (nom_s_c), INDEX nom_c (nom_c, nom_s_c, nom_m), INDEX IDX_29A5EC272AF2F06E (nom_c), PRIMARY KEY(id_p, titre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE souscategorie (id_s_c INT AUTO_INCREMENT NOT NULL, nom_s_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nom_c VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX nom_c (nom_c), INDEX nom_s_c (nom_s_c), PRIMARY KEY(id_s_c, nom_s_c)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (Idu INT AUTO_INCREMENT NOT NULL, Cin VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Nom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Prenom VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Tel VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Email VARCHAR(38) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Password VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Image VARCHAR(1000) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, Role INT DEFAULT 0, dateNaissance DATE DEFAULT NULL, PRIMARY KEY(Idu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT marque_ibfk_2 FOREIGN KEY (nom_c) REFERENCES categorie (nom_c)');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT marque_ibfk_1 FOREIGN KEY (nom_s_c) REFERENCES souscategorie (nom_s_c)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT offre_ibfk_1 FOREIGN KEY (id_article) REFERENCES article (id_article) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT offre_ibfk_2 FOREIGN KEY (Idu) REFERENCES user (Idu)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT produit_ibfk_1 FOREIGN KEY (nom_c) REFERENCES categorie (nom_c)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT produit_ibfk_2 FOREIGN KEY (nom_s_c) REFERENCES souscategorie (nom_s_c)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT produit_ibfk_3 FOREIGN KEY (nom_m) REFERENCES marque (nom_m)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT souscategorie_ibfk_1 FOREIGN KEY (nom_c) REFERENCES categorie (nom_c)');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE article ADD sous_categorie VARCHAR(50) NOT NULL, ADD Idu INT NOT NULL, ADD periode_utilistation VARCHAR(50) NOT NULL, DROP periode_utilisation, DROP souscategorie, CHANGE nom_article nom_article VARCHAR(50) NOT NULL, CHANGE description description VARCHAR(50) NOT NULL, CHANGE image image TEXT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT article_ibfk_3 FOREIGN KEY (sous_categorie) REFERENCES souscategorie (nom_s_c)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT article_ibfk_1 FOREIGN KEY (categorie) REFERENCES categorie (nom_c)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT article_ibfk_4 FOREIGN KEY (Idu) REFERENCES user (Idu)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT article_ibfk_2 FOREIGN KEY (marque) REFERENCES marque (nom_m)');
        $this->addSql('CREATE INDEX Idu ON article (Idu)');
        $this->addSql('CREATE INDEX marque ON article (marque)');
        $this->addSql('CREATE INDEX categorie ON article (categorie, sous_categorie, marque)');
        $this->addSql('CREATE INDEX sous_categorie ON article (sous_categorie)');
        $this->addSql('CREATE INDEX IDX_23A0E66497DD634 ON article (categorie)');
    }
}
