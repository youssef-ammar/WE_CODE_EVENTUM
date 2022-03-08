<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301011849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reservationvoy (id INT AUTO_INCREMENT NOT NULL, voyage_id INT DEFAULT NULL, id_client_id INT DEFAULT NULL, date_reser_voy DATE NOT NULL, INDEX IDX_BAF221D768C9E5AF (voyage_id), INDEX IDX_BAF221D799DED506 (id_client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, date_debut_voy DATE NOT NULL, date_fin_voy DATE NOT NULL, descri_voy VARCHAR(255) NOT NULL, destination_voy VARCHAR(255) NOT NULL, nbre_place_voy INT NOT NULL, image_voy VARCHAR(255) NOT NULL, prix_voy DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservationvoy ADD CONSTRAINT FK_BAF221D768C9E5AF FOREIGN KEY (voyage_id) REFERENCES comment (id)');
        $this->addSql('ALTER TABLE reservationvoy ADD CONSTRAINT FK_BAF221D799DED506 FOREIGN KEY (id_client_id) REFERENCES utilisateur (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservationvoy DROP FOREIGN KEY FK_BAF221D768C9E5AF');
        $this->addSql('DROP TABLE reservationvoy');
        $this->addSql('DROP TABLE comment');
    }
}
