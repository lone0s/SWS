<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220425173628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_article');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, libelle, price, quantity FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id_article INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id_article, libelle, price, quantity) SELECT id, libelle, price, quantity FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('DROP INDEX UNIQ_A3B536FDAA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_user AS SELECT id, login, roles, password, first_name, last_name FROM auth_user');
        $this->addSql('DROP TABLE auth_user');
        $this->addSql('CREATE TABLE auth_user (id_user INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO auth_user (id_user, login, roles, password, first_name, last_name) SELECT id, login, roles, password, first_name, last_name FROM __temp__auth_user');
        $this->addSql('DROP TABLE __temp__auth_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDAA08CB10 ON auth_user (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF279F37AE5 ON panier (id_user_id)');
        $this->addSql('CREATE TABLE panier_article (panier_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(panier_id, article_id))');
        $this->addSql('CREATE INDEX IDX_F880CAE7F77D927C ON panier_article (panier_id)');
        $this->addSql('CREATE INDEX IDX_F880CAE77294869C ON panier_article (article_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id_article, libelle, price, quantity FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, quantity INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO article (id, libelle, price, quantity) SELECT id_article, libelle, price, quantity FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
        $this->addSql('DROP INDEX UNIQ_A3B536FDAA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_user AS SELECT id_user, login, roles, password, first_name, last_name FROM auth_user');
        $this->addSql('DROP TABLE auth_user');
        $this->addSql('CREATE TABLE auth_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO auth_user (id, login, roles, password, first_name, last_name) SELECT id_user, login, roles, password, first_name, last_name FROM __temp__auth_user');
        $this->addSql('DROP TABLE __temp__auth_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDAA08CB10 ON auth_user (login)');
    }
}
