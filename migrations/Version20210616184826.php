<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210616184826 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_94D4687F12469DE2 ON competence (category_id)');
        $this->addSql('ALTER TABLE profile ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_8157AA0F12469DE2 ON profile (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687F12469DE2');
        $this->addSql('DROP INDEX IDX_94D4687F12469DE2 ON competence');
        $this->addSql('ALTER TABLE competence DROP category_id');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F12469DE2');
        $this->addSql('DROP INDEX IDX_8157AA0F12469DE2 ON profile');
        $this->addSql('ALTER TABLE profile DROP category_id');
    }
}
