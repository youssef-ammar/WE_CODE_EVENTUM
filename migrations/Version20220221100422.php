<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220221100422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_camp DROP FOREIGN KEY FK_D7AD8F583CC6385');
        $this->addSql('DROP INDEX IDX_D7AD8F583CC6385 ON reservation_camp');
        $this->addSql('ALTER TABLE reservation_camp DROP camping_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_camp ADD camping_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation_camp ADD CONSTRAINT FK_D7AD8F583CC6385 FOREIGN KEY (camping_id) REFERENCES camping (id)');
        $this->addSql('CREATE INDEX IDX_D7AD8F583CC6385 ON reservation_camp (camping_id)');
    }
}
