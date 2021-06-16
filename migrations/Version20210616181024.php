<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616181024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_competence (profile_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_53BF5F22CCFA12B8 (profile_id), INDEX IDX_53BF5F2215761DAB (competence_id), PRIMARY KEY(profile_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_competence ADD CONSTRAINT FK_53BF5F22CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_competence ADD CONSTRAINT FK_53BF5F2215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience ADD profile_id INT NOT NULL, ADD company_id INT NOT NULL');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('CREATE INDEX IDX_590C103CCFA12B8 ON experience (profile_id)');
        $this->addSql('CREATE INDEX IDX_590C103979B1AD6 ON experience (company_id)');
        $this->addSql('ALTER TABLE user ADD profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649CCFA12B8 ON user (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_competence');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103CCFA12B8');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103979B1AD6');
        $this->addSql('DROP INDEX IDX_590C103CCFA12B8 ON experience');
        $this->addSql('DROP INDEX IDX_590C103979B1AD6 ON experience');
        $this->addSql('ALTER TABLE experience DROP profile_id, DROP company_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_8D93D649CCFA12B8 ON user');
        $this->addSql('ALTER TABLE user DROP profile_id');
    }
}
