<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220224002934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bookmark_topic (bookmark_id INT NOT NULL, topic_id INT NOT NULL, INDEX IDX_12C7D8DC92741D25 (bookmark_id), INDEX IDX_12C7D8DC1F55203D (topic_id), PRIMARY KEY(bookmark_id, topic_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bookmark_topic ADD CONSTRAINT FK_12C7D8DC92741D25 FOREIGN KEY (bookmark_id) REFERENCES bookmark (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bookmark_topic ADD CONSTRAINT FK_12C7D8DC1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE bookmark_topic');
    }
}
