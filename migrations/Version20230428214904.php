<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428214904 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id_article INT AUTO_INCREMENT NOT NULL, id INT DEFAULT NULL, nom_article VARCHAR(255) NOT NULL, periode_utilisation VARCHAR(50) NOT NULL, etat VARCHAR(50) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, marque VARCHAR(50) NOT NULL, sous_categorie VARCHAR(50) NOT NULL, categorie VARCHAR(50) NOT NULL, INDEX IDX_23A0E66BF396750 (id), PRIMARY KEY(id_article)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, idu_sender INT NOT NULL, idu_receiver INT NOT NULL, id_article INT DEFAULT NULL, objet LONGTEXT NOT NULL, content LONGTEXT NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_B6BD307F10187AA2 (idu_sender), INDEX IDX_B6BD307FCB32E6C8 (idu_receiver), INDEX IDX_B6BD307FDCA7A716 (id_article), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, nom VARCHAR(180) NOT NULL, prenom VARCHAR(180) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, isbanned TINYINT(1) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, gender VARCHAR(255) NOT NULL, age INT NOT NULL, is_verified TINYINT(1) NOT NULL, reset_token VARCHAR(100) NOT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66BF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F10187AA2 FOREIGN KEY (idu_sender) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCB32E6C8 FOREIGN KEY (idu_receiver) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FDCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FBF396750 FOREIGN KEY (id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FDCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FDCA7A716');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FBF396750');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66BF396750');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F10187AA2');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCB32E6C8');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FDCA7A716');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
