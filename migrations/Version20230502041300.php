<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502041300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id_article INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, nom_article VARCHAR(255) NOT NULL, periode_utilisation VARCHAR(50) NOT NULL, etat VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_23A0E66BF396750 (id), INDEX IDX_23A0E66BCF5E72D (categorie_id), INDEX IDX_23A0E664827B9B2 (marque_id), INDEX IDX_23A0E66365BF48 (sous_categorie_id), FULLTEXT INDEX article (nom_article), PRIMARY KEY(id_article)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE boutique (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, num_telephone INT NOT NULL, num_fixe INT NOT NULL, gouvernorat VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, INDEX IDX_A1223C54A76ED395 (user_id), FULLTEXT INDEX boutique (nom, ville), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_c VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, gagnant_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_3755B50D2F942B8 (gagnant_id), FULLTEXT INDEX jeux (titre, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE marque (id INT AUTO_INCREMENT NOT NULL, souscategorie_id INT DEFAULT NULL, categorie_id INT DEFAULT NULL, nom_m VARCHAR(255) NOT NULL, INDEX IDX_5A6F91CEA27126E0 (souscategorie_id), INDEX IDX_5A6F91CEBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, idu_sender INT NOT NULL, idu_receiver INT NOT NULL, id_article INT DEFAULT NULL, objet LONGTEXT NOT NULL, content LONGTEXT NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_B6BD307F10187AA2 (idu_sender), INDEX IDX_B6BD307FCB32E6C8 (idu_receiver), INDEX IDX_B6BD307FDCA7A716 (id_article), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id_offre INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, id_article INT DEFAULT NULL, categorie_id INT DEFAULT NULL, marque_id INT DEFAULT NULL, sous_categorie_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, produit_propose VARCHAR(50) NOT NULL, periode_utilisation VARCHAR(50) NOT NULL, etat_produit_propose VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, bonus VARCHAR(100) DEFAULT NULL, num_tel INT NOT NULL, INDEX IDX_AF86866FBF396750 (id), INDEX IDX_AF86866FDCA7A716 (id_article), INDEX IDX_AF86866FBCF5E72D (categorie_id), INDEX IDX_AF86866F4827B9B2 (marque_id), INDEX IDX_AF86866F365BF48 (sous_categorie_id), PRIMARY KEY(id_offre)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, jeux_id INT DEFAULT NULL, INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24FEC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, boutique_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_29A5EC27AB677BE6 (boutique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(50) NOT NULL, destinataire VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, treated TINYINT(1) NOT NULL, INDEX IDX_CE606404A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response (id INT AUTO_INCREMENT NOT NULL, reclamation_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_3E7B0BFB2D6BA2D9 (reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, rate INT NOT NULL, comment VARCHAR(255) NOT NULL, likes INT DEFAULT NULL, dislikes INT DEFAULT NULL, INDEX IDX_794381C67294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE souscategorie (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, nom_s_c VARCHAR(255) NOT NULL, INDEX IDX_6FF3A701BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE suggestion (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, sugg_c VARCHAR(255) DEFAULT NULL, sugg_s VARCHAR(255) DEFAULT NULL, sugg_m VARCHAR(255) DEFAULT NULL, etatc VARCHAR(255) DEFAULT \'non défini\' NOT NULL, etats VARCHAR(255) DEFAULT \'non défini\' NOT NULL, etatm VARCHAR(255) DEFAULT \'non défini\' NOT NULL, INDEX IDX_DD80F31BA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, isbanned TINYINT(1) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, age INT NOT NULL, is_verified TINYINT(1) NOT NULL, reset_token VARCHAR(100) DEFAULT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_jeux (user_id INT NOT NULL, jeux_id INT NOT NULL, INDEX IDX_4DD4F9C4A76ED395 (user_id), INDEX IDX_4DD4F9C4EC2AA9D2 (jeux_id), PRIMARY KEY(user_id, jeux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E664827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES souscategorie (id)');
        $this->addSql('ALTER TABLE boutique ADD CONSTRAINT FK_A1223C54A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D2F942B8 FOREIGN KEY (gagnant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CEA27126E0 FOREIGN KEY (souscategorie_id) REFERENCES souscategorie (id)');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CEBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F10187AA2 FOREIGN KEY (idu_sender) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCB32E6C8 FOREIGN KEY (idu_receiver) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FDCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FDCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F4827B9B2 FOREIGN KEY (marque_id) REFERENCES marque (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F365BF48 FOREIGN KEY (sous_categorie_id) REFERENCES souscategorie (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27AB677BE6 FOREIGN KEY (boutique_id) REFERENCES boutique (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C67294869C FOREIGN KEY (article_id) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE souscategorie ADD CONSTRAINT FK_6FF3A701BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_jeux ADD CONSTRAINT FK_4DD4F9C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_jeux ADD CONSTRAINT FK_4DD4F9C4EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BF396750');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BCF5E72D');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E664827B9B2');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66365BF48');
        $this->addSql('ALTER TABLE boutique DROP FOREIGN KEY FK_A1223C54A76ED395');
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D2F942B8');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CEA27126E0');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CEBCF5E72D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F10187AA2');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCB32E6C8');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FDCA7A716');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBF396750');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FDCA7A716');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBCF5E72D');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F4827B9B2');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F365BF48');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FEC2AA9D2');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27AB677BE6');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB2D6BA2D9');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C67294869C');
        $this->addSql('ALTER TABLE souscategorie DROP FOREIGN KEY FK_6FF3A701BCF5E72D');
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31BA76ED395');
        $this->addSql('ALTER TABLE user_jeux DROP FOREIGN KEY FK_4DD4F9C4A76ED395');
        $this->addSql('ALTER TABLE user_jeux DROP FOREIGN KEY FK_4DD4F9C4EC2AA9D2');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE boutique');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE marque');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE response');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE souscategorie');
        $this->addSql('DROP TABLE suggestion');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_jeux');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
