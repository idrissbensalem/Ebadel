<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430190558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE jeux (id INT AUTO_INCREMENT NOT NULL, gagnant_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, produit VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_3755B50D2F942B8 (gagnant_id), FULLTEXT INDEX jeux (titre, type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, jeux_id INT DEFAULT NULL, INDEX IDX_AB55E24FA76ED395 (user_id), INDEX IDX_AB55E24FEC2AA9D2 (jeux_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_jeux (user_id INT NOT NULL, jeux_id INT NOT NULL, INDEX IDX_4DD4F9C4A76ED395 (user_id), INDEX IDX_4DD4F9C4EC2AA9D2 (jeux_id), PRIMARY KEY(user_id, jeux_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D2F942B8 FOREIGN KEY (gagnant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participation ADD CONSTRAINT FK_AB55E24FEC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id)');
        $this->addSql('ALTER TABLE user_jeux ADD CONSTRAINT FK_4DD4F9C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_jeux ADD CONSTRAINT FK_4DD4F9C4EC2AA9D2 FOREIGN KEY (jeux_id) REFERENCES jeux (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D2F942B8');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FA76ED395');
        $this->addSql('ALTER TABLE participation DROP FOREIGN KEY FK_AB55E24FEC2AA9D2');
        $this->addSql('ALTER TABLE user_jeux DROP FOREIGN KEY FK_4DD4F9C4A76ED395');
        $this->addSql('ALTER TABLE user_jeux DROP FOREIGN KEY FK_4DD4F9C4EC2AA9D2');
        $this->addSql('DROP TABLE jeux');
        $this->addSql('DROP TABLE participation');
        $this->addSql('DROP TABLE user_jeux');
    }
}
