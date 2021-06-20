<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210620145102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE profile_competence (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, competence_id INT NOT NULL, level SMALLINT NOT NULL, liked TINYINT(1) NOT NULL, INDEX IDX_53BF5F22CCFA12B8 (profile_id), INDEX IDX_53BF5F2215761DAB (competence_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile_competence ADD CONSTRAINT FK_53BF5F22CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE profile_competence ADD CONSTRAINT FK_53BF5F2215761DAB FOREIGN KEY (competence_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competence DROP level, DROP liked');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE profile_competence');
        $this->addSql('ALTER TABLE competence ADD level SMALLINT NOT NULL, ADD liked TINYINT(1) NOT NULL');
    }
}
