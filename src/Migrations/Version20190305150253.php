<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190305150253 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE panier');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP nom, DROP prenom, DROP adresse');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, produit_id_id INT DEFAULT NULL, user_id_id INT DEFAULT NULL, quantite_produit INT NOT NULL, prix_total DOUBLE PRECISION NOT NULL, INDEX IDX_24CC0DF29D86650F (user_id_id), INDEX IDX_24CC0DF24FD8F9C3 (produit_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF24FD8F9C3 FOREIGN KEY (produit_id_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD adresse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP username, DROP password');
    }
}
