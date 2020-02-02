<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200202184515 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE genre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE produit_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE genre (id INT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE genre_produit (genre_id INT NOT NULL, produit_id INT NOT NULL, PRIMARY KEY(genre_id, produit_id))');
        $this->addSql('CREATE INDEX IDX_12207FDF4296D31F ON genre_produit (genre_id)');
        $this->addSql('CREATE INDEX IDX_12207FDFF347EFB ON genre_produit (produit_id)');
        $this->addSql('CREATE TABLE produit (id INT NOT NULL, title VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, year VARCHAR(255) NOT NULL, country VARCHAR(3) NOT NULL, original_title VARCHAR(250) DEFAULT NULL, description TEXT DEFAULT NULL, ranking INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE produit_genre (product_id INT NOT NULL, genre_id INT NOT NULL, PRIMARY KEY(product_id, genre_id))');
        $this->addSql('CREATE INDEX IDX_B3CC546C4584665A ON produit_genre (product_id)');
        $this->addSql('CREATE INDEX IDX_B3CC546C4296D31F ON produit_genre (genre_id)');
        $this->addSql('ALTER TABLE genre_produit ADD CONSTRAINT FK_12207FDF4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE genre_produit ADD CONSTRAINT FK_12207FDFF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_genre ADD CONSTRAINT FK_B3CC546C4584665A FOREIGN KEY (product_id) REFERENCES produit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE produit_genre ADD CONSTRAINT FK_B3CC546C4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE genre_produit DROP CONSTRAINT FK_12207FDF4296D31F');
        $this->addSql('ALTER TABLE produit_genre DROP CONSTRAINT FK_B3CC546C4296D31F');
        $this->addSql('ALTER TABLE genre_produit DROP CONSTRAINT FK_12207FDFF347EFB');
        $this->addSql('ALTER TABLE produit_genre DROP CONSTRAINT FK_B3CC546C4584665A');
        $this->addSql('DROP SEQUENCE genre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE produit_id_seq CASCADE');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE genre_produit');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE produit_genre');
    }
}
