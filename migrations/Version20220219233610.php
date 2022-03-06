<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220219233610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3C0ED449F');
        $this->addSql('ALTER TABLE cmt DROP FOREIGN KEY FK_32EB0CA429CCBAD0');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DF347EFB');
        $this->addSql('CREATE TABLE reservation_camp (id INT AUTO_INCREMENT NOT NULL, camping_id INT DEFAULT NULL, date_reser DATE DEFAULT NULL, msg VARCHAR(255) DEFAULT NULL, idcamp INT DEFAULT NULL, INDEX IDX_D7AD8F583CC6385 (camping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation_camp ADD CONSTRAINT FK_D7AD8F583CC6385 FOREIGN KEY (camping_id) REFERENCES camping (id)');
        $this->addSql('DROP TABLE carte_fidelite');
        $this->addSql('DROP TABLE cmt');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE forum');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE reservationcamp');
        $this->addSql('DROP TABLE reservationevent');
        $this->addSql('DROP TABLE reservationvoy');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE voyage');
        $this->addSql('ALTER TABLE camping ADD nom VARCHAR(255) DEFAULT NULL, ADD date_debut DATE DEFAULT NULL, ADD date_fin DATE DEFAULT NULL, ADD lieu VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD nb_place INT DEFAULT NULL, ADD prix DOUBLE PRECISION DEFAULT NULL, ADD image VARCHAR(255) DEFAULT NULL, DROP nom_camp, DROP date_debut_camp, DROP date_fin_camp, DROP lieu_camp, DROP descri_camp, DROP nbre_place_camp, DROP image_camp, DROP prix_camp');
        $this->addSql('ALTER TABLE categorie ADD nom VARCHAR(255) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, DROP nom_categorie');
        $this->addSql('ALTER TABLE event ADD nom VARCHAR(255) NOT NULL, ADD date_debut DATE DEFAULT NULL, ADD date_fin DATE DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, ADD prix DOUBLE PRECISION DEFAULT NULL, DROP nom_event, DROP date_debut_event, DROP date_fin_event, DROP lieu_event, DROP prix_event, CHANGE categorie_id categorie_id INT NOT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE descri_event lieu VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte_fidelite (id INT AUTO_INCREMENT NOT NULL, num_fid INT NOT NULL, date_debut_fid DATE NOT NULL, date_fin_fid DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE cmt (id INT AUTO_INCREMENT NOT NULL, forum_id INT DEFAULT NULL, descri_cmt VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_32EB0CA429CCBAD0 (forum_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, produit_id INT DEFAULT NULL, date_cmd DATE NOT NULL, INDEX IDX_6EEAA67DF347EFB (produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE forum (id INT AUTO_INCREMENT NOT NULL, sujet_forum VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, descri_forum VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image_forum VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, nom_prod VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_prod DATE NOT NULL, prix_prod DOUBLE PRECISION NOT NULL, descri_prod VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, stock_prod INT NOT NULL, image_prod VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservationcamp (id INT AUTO_INCREMENT NOT NULL, camping_id INT DEFAULT NULL, date_reserc_camp DATE NOT NULL, INDEX IDX_D9FD76153CC6385 (camping_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservationevent (id INT AUTO_INCREMENT NOT NULL, date_reser_event DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservationvoy (id INT AUTO_INCREMENT NOT NULL, date_reser_voy DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE student (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_nai VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, carte_fid_id INT NOT NULL, mot_passe_utili VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, nom_utili VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, tel_utili INT DEFAULT NULL, role INT NOT NULL, type INT NOT NULL, nbre_place INT DEFAULT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_1D1C63B3C0ED449F (carte_fid_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voyage (id INT AUTO_INCREMENT NOT NULL, date_debut_voy DATE NOT NULL, date_fin_voy DATE NOT NULL, descri_voy VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, destination_voy VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, nbre_place_voy INT NOT NULL, image_voy VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix_voy DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cmt ADD CONSTRAINT FK_32EB0CA429CCBAD0 FOREIGN KEY (forum_id) REFERENCES forum (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE reservationcamp ADD CONSTRAINT FK_D9FD76153CC6385 FOREIGN KEY (camping_id) REFERENCES camping (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3C0ED449F FOREIGN KEY (carte_fid_id) REFERENCES carte_fidelite (id)');
        $this->addSql('DROP TABLE reservation_camp');
        $this->addSql('ALTER TABLE camping ADD nom_camp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD date_debut_camp DATE NOT NULL, ADD date_fin_camp DATE NOT NULL, ADD lieu_camp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD descri_camp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD nbre_place_camp INT NOT NULL, ADD image_camp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prix_camp DOUBLE PRECISION NOT NULL, DROP nom, DROP date_debut, DROP date_fin, DROP lieu, DROP description, DROP nb_place, DROP prix, DROP image');
        $this->addSql('ALTER TABLE categorie ADD nom_categorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP nom, DROP description');
        $this->addSql('ALTER TABLE event ADD date_debut_event DATE NOT NULL, ADD date_fin_event DATE NOT NULL, ADD lieu_event VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD descri_event VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD prix_event DOUBLE PRECISION NOT NULL, DROP date_debut, DROP date_fin, DROP lieu, DROP description, DROP prix, CHANGE categorie_id categorie_id INT DEFAULT NULL, CHANGE image image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE nom nom_event VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
