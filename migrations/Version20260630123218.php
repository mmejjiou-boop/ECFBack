<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260630123218 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE97916880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE pret ADD CONSTRAINT FK_52ECE97925F06C53 FOREIGN KEY (adherent_id) REFERENCES adherent (id)');
        $this->addSql('CREATE INDEX IDX_52ECE97916880AAF ON pret (materiel_id)');
        $this->addSql('CREATE INDEX IDX_52ECE97925F06C53 ON pret (adherent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE97916880AAF');
        $this->addSql('ALTER TABLE pret DROP FOREIGN KEY FK_52ECE97925F06C53');
        $this->addSql('DROP INDEX IDX_52ECE97916880AAF ON pret');
        $this->addSql('DROP INDEX IDX_52ECE97925F06C53 ON pret');
    }
}
