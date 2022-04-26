<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220426154349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX au_idx');
        $this->addSql('DROP INDEX IDX_236008C46B3CA4B');
        $this->addSql('DROP INDEX IDX_236008C4DCA7A716');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, id_user, id_article, quantite FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_article INTEGER DEFAULT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_236008C46B3CA4B FOREIGN KEY (id_user) REFERENCES auth_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_236008C4DCA7A716 FOREIGN KEY (id_article) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (id, id_user, id_article, quantite) SELECT id, id_user, id_article, quantite FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON panier (id_user, id_article, quantite)');
        $this->addSql('CREATE INDEX IDX_236008C46B3CA4B ON panier (id_user)');
        $this->addSql('CREATE INDEX IDX_236008C4DCA7A716 ON panier (id_article)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_236008C46B3CA4B');
        $this->addSql('DROP INDEX IDX_236008C4DCA7A716');
        $this->addSql('DROP INDEX au_idx');
        $this->addSql('CREATE TEMPORARY TABLE __temp__Panier AS SELECT id, id_user, id_article, quantite FROM Panier');
        $this->addSql('DROP TABLE Panier');
        $this->addSql('CREATE TABLE Panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user INTEGER NOT NULL, id_article INTEGER DEFAULT NULL, quantite INTEGER NOT NULL)');
        $this->addSql('INSERT INTO Panier (id, id_user, id_article, quantite) SELECT id, id_user, id_article, quantite FROM __temp__Panier');
        $this->addSql('DROP TABLE __temp__Panier');
        $this->addSql('CREATE INDEX IDX_236008C46B3CA4B ON Panier (id_user)');
        $this->addSql('CREATE INDEX IDX_236008C4DCA7A716 ON Panier (id_article)');
        $this->addSql('CREATE UNIQUE INDEX au_idx ON Panier (id_user, id_article, quantite)');
    }
}
