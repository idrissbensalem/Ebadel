<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430230652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE suggestion (id_s INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, sugg_c VARCHAR(100) DEFAULT NULL, sugg_s VARCHAR(100) DEFAULT NULL, sugg_m VARCHAR(100) DEFAULT NULL, etatC VARCHAR(20) NOT NULL, etatS VARCHAR(20) NOT NULL, etatM VARCHAR(20) DEFAULT NULL, INDEX IDX_DD80F31BE173B1B8 (id_client), PRIMARY KEY(id_s)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE suggestion ADD CONSTRAINT FK_DD80F31BE173B1B8 FOREIGN KEY (id_client) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suggestion DROP FOREIGN KEY FK_DD80F31BE173B1B8');
        $this->addSql('DROP TABLE suggestion');
    }
}
