<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230429154823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6BF396750');
        $this->addSql('ALTER TABLE review ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C67294869C FOREIGN KEY (article_id) REFERENCES article (id_article)');
        $this->addSql('CREATE INDEX IDX_794381C67294869C ON review (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C67294869C');
        $this->addSql('DROP INDEX IDX_794381C67294869C ON review');
        $this->addSql('ALTER TABLE review DROP article_id');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6BF396750 FOREIGN KEY (id) REFERENCES article (id_article)');
    }
}
