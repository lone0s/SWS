<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220420102104 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE auth_user ADD COLUMN first_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE auth_user ADD COLUMN last_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_A3B536FDAA08CB10');
        $this->addSql('CREATE TEMPORARY TABLE __temp__auth_user AS SELECT id, login, roles, password FROM auth_user');
        $this->addSql('DROP TABLE auth_user');
        $this->addSql('CREATE TABLE auth_user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO auth_user (id, login, roles, password) SELECT id, login, roles, password FROM __temp__auth_user');
        $this->addSql('DROP TABLE __temp__auth_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A3B536FDAA08CB10 ON auth_user (login)');
    }
}
