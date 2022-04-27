<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427082831 extends AbstractMigration
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
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_article INTEGER DEFAULT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_236008C46B3CA4B FOREIGN KEY (id_user) REFERENCES auth_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_236008C4DCA7A716 FOREIGN KEY (id_article) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (id, id_user, id_article, quantite) SELECT id, user_id, article_id, quantite FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON panier (id_user, id_article, quantite)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_236008C46B3CA4B ON panier (id_user)');
        $this->addSql('CREATE INDEX IDX_236008C4DCA7A716 ON panier (id_article)');
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
        $this->addSql('DROP INDEX UNIQ_236008C46B3CA4B');
        $this->addSql('DROP INDEX IDX_236008C4DCA7A716');
        $this->addSql('DROP INDEX au_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Panier AS SELECT id, id_user, id_article, quantite FROM Panier');
        $this->addSql('DROP TABLE Panier');
        $this->addSql('CREATE TABLE Panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, article_id INTEGER DEFAULT NULL, quantite INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO Panier (id, user_id, article_id, quantite) SELECT id, id_user, id_article, quantite FROM __temp__Panier');
        $this->addSql('DROP TABLE __temp__Panier');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON Panier (user_id, article_id, quantite)');
        $this->addSql('CREATE INDEX IDX_236008C47294869C ON Panier (article_id)');
        $this->addSql('CREATE INDEX IDX_236008C4A76ED395 ON Panier (user_id)');
    }
}
