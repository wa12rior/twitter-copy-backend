<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220115125830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add profile follow';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_follow (id UUID NOT NULL, source_id UUID NOT NULL, target_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1E2317953C1C61 ON profile_follow (source_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1E2317158E0B66 ON profile_follow (target_id)');
        $this->addSql('COMMENT ON COLUMN profile_follow.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN profile_follow.source_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN profile_follow.target_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE profile_follow ADD CONSTRAINT FK_1E2317953C1C61 FOREIGN KEY (source_id) REFERENCES application_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE profile_follow ADD CONSTRAINT FK_1E2317158E0B66 FOREIGN KEY (target_id) REFERENCES application_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_follow');
    }
}
