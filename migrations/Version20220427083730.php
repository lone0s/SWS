<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427083730 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_article INTEGER DEFAULT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_236008C46B3CA4B ON Panier (id_user)');
        $this->addSql('CREATE INDEX IDX_236008C4DCA7A716 ON Panier (id_article)');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON Panier (id_user, id_article, quantite)');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE auth_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDAA08CB10 ON auth_user (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Panier');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE auth_user');
    }
}
