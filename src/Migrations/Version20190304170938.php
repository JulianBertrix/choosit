<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304170938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE panier ADD produit_id_id INT DEFAULT NULL, ADD user_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF24FD8F9C3 FOREIGN KEY (produit_id_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF29D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF24FD8F9C3 ON panier (produit_id_id)');
        $this->addSql('CREATE INDEX IDX_24CC0DF29D86650F ON panier (user_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF24FD8F9C3');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF29D86650F');
        $this->addSql('DROP INDEX IDX_24CC0DF24FD8F9C3 ON panier');
        $this->addSql('DROP INDEX IDX_24CC0DF29D86650F ON panier');
        $this->addSql('ALTER TABLE panier DROP produit_id_id, DROP user_id_id');
    }
}
