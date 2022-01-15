<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115104817 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user and tweet';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE application_user (id UUID NOT NULL, email VARCHAR(180) NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7A7FBEC1E7927C74 ON application_user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7A7FBEC1F85E0677 ON application_user (username)');
        $this->addSql('COMMENT ON COLUMN application_user.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN application_user.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN application_user.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE tweet (id UUID NOT NULL, created_by_id UUID NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D660A3BB03A8386 ON tweet (created_by_id)');
        $this->addSql('COMMENT ON COLUMN tweet.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tweet.created_by_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN tweet.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN tweet.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE tweet ADD CONSTRAINT FK_3D660A3BB03A8386 FOREIGN KEY (created_by_id) REFERENCES application_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE tweet DROP CONSTRAINT FK_3D660A3BB03A8386');
        $this->addSql('DROP TABLE application_user');
        $this->addSql('DROP TABLE tweet');
    }
}
