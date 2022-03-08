<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308055048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('DROP TABLE conversation');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5BB66C05 FOREIGN KEY (poster_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_9474526C5BB66C05 ON comment (poster_id)');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('DROP INDEX IDX_B6BD307F9AC0396 ON message');
        $this->addSql('DROP INDEX created_at_index ON message');
        $this->addSql('ALTER TABLE message ADD sender_id INT NOT NULL, ADD recipient_id INT NOT NULL, DROP conversation_id, DROP user_id, CHANGE content message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FE92F8F78 FOREIGN KEY (recipient_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE92F8F78 ON message (recipient_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, last_message_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_8A8E26E9BA0E79C3 (last_message_id), INDEX last_message_id_index (last_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE conversation ADD CONSTRAINT FK_8A8E26E9BA0E79C3 FOREIGN KEY (last_message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5BB66C05');
        $this->addSql('DROP INDEX IDX_9474526C5BB66C05 ON comment');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FE92F8F78');
        $this->addSql('DROP INDEX IDX_B6BD307FF624B39D ON message');
        $this->addSql('DROP INDEX IDX_B6BD307FE92F8F78 ON message');
        $this->addSql('ALTER TABLE message ADD conversation_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP sender_id, DROP recipient_id, CHANGE message content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)');
        $this->addSql('CREATE INDEX created_at_index ON message (created_at)');
    }
}
