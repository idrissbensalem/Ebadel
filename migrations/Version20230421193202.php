<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230421193202 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux ADD gagnant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE jeux ADD CONSTRAINT FK_3755B50D2F942B8 FOREIGN KEY (gagnant_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_3755B50D2F942B8 ON jeux (gagnant_id)');
        $this->addSql('ALTER TABLE participation CHANGE jeux_id jeux_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE jeux DROP FOREIGN KEY FK_3755B50D2F942B8');
        $this->addSql('DROP INDEX IDX_3755B50D2F942B8 ON jeux');
        $this->addSql('ALTER TABLE jeux DROP gagnant_id');
        $this->addSql('ALTER TABLE participation CHANGE jeux_id jeux_id INT NOT NULL');
    }
}
