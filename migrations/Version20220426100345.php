<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426100345 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_236008C47294869C');
        $this->addSql('DROP INDEX IDX_236008C4A76ED395');
        $this->addSql('DROP INDEX au_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, user_id, article_id, quantite FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, article_id INTEGER DEFAULT NULL, quantite INTEGER DEFAULT NULL, CONSTRAINT FK_236008C4A76ED395 FOREIGN KEY (user_id) REFERENCES auth_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_236008C47294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (id, user_id, article_id, quantite) SELECT id, user_id, article_id, quantite FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE INDEX IDX_236008C47294869C ON panier (article_id)');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON panier (user_id, article_id, quantite)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_236008C4A76ED395 ON panier (user_id)');
        $this->addSql('DROP INDEX UNIQ_A3B536FDF77D927C');
        $this->addSql('DROP INDEX UNIQ_A3B536FDAA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_user AS SELECT id, login, roles, password, first_name, last_name FROM auth_user');
        $this->addSql('DROP TABLE auth_user');
        $this->addSql('CREATE TABLE auth_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO auth_user (id, login, roles, password, first_name, last_name) SELECT id, login, roles, password, first_name, last_name FROM __temp__auth_user');
        $this->addSql('DROP TABLE __temp__auth_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDAA08CB10 ON auth_user (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_A3B536FDAA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_user AS SELECT id, login, roles, password, first_name, last_name FROM auth_user');
        $this->addSql('DROP TABLE auth_user');
        $this->addSql('CREATE TABLE auth_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, panier_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO auth_user (id, login, roles, password, first_name, last_name) SELECT id, login, roles, password, first_name, last_name FROM __temp__auth_user');
        $this->addSql('DROP TABLE __temp__auth_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDAA08CB10 ON auth_user (login)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDF77D927C ON auth_user (panier_id)');
        $this->addSql('DROP INDEX UNIQ_236008C4A76ED395');
        $this->addSql('DROP INDEX IDX_236008C47294869C');
        $this->addSql('DROP INDEX au_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Panier AS SELECT id, user_id, article_id, quantite FROM Panier');
        $this->addSql('DROP TABLE Panier');
        $this->addSql('CREATE TABLE Panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, article_id INTEGER DEFAULT NULL, quantite INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO Panier (id, user_id, article_id, quantite) SELECT id, user_id, article_id, quantite FROM __temp__Panier');
        $this->addSql('DROP TABLE __temp__Panier');
        $this->addSql('CREATE INDEX IDX_236008C47294869C ON Panier (article_id)');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON Panier (user_id, article_id, quantite)');
        $this->addSql('CREATE INDEX IDX_236008C4A76ED395 ON Panier (user_id)');
    }
}
