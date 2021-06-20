<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210620143141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_competence');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_competence (profile_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_53BF5F2215761DAB (competence_id), INDEX IDX_53BF5F22CCFA12B8 (profile_id), PRIMARY KEY(profile_id, competence_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE profile_competence ADD CONSTRAINT FK_53BF5F2215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile_competence ADD CONSTRAINT FK_53BF5F22CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
