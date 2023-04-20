<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420082555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (idu INT AUTO_INCREMENT NOT NULL, cin VARCHAR(20) NOT NULL, nom VARCHAR(20) NOT NULL, prenom VARCHAR(20) NOT NULL, tel VARCHAR(20) NOT NULL, email VARCHAR(50) NOT NULL, password VARCHAR(50) NOT NULL, image VARCHAR(255) DEFAULT NULL, role INT DEFAULT NULL, datenaissance DATE DEFAULT NULL, PRIMARY KEY(idu)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD idu INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6699B902AD FOREIGN KEY (idu) REFERENCES user (idu)');
        $this->addSql('CREATE INDEX IDX_23A0E6699B902AD ON article (idu)');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY offre_ibfk_1');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FDCA7A716 FOREIGN KEY (id_article) REFERENCES article (id_article)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6699B902AD');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_23A0E6699B902AD ON article');
        $this->addSql('ALTER TABLE article DROP idu');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FDCA7A716');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT offre_ibfk_1 FOREIGN KEY (id_article) REFERENCES article (id_article) ON UPDATE SET NULL ON DELETE CASCADE');
    }
}
