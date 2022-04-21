<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421143129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_24CC0DF279F37AE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, id_user_id FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL, quantite INTEGER NOT NULL, CONSTRAINT FK_24CC0DF279F37AE5 FOREIGN KEY (id_user_id) REFERENCES auth_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier (id, id_user_id) SELECT id, id_user_id FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF279F37AE5 ON panier (id_user_id)');
        $this->addSql('DROP INDEX IDX_F880CAE77294869C');
        $this->addSql('DROP INDEX IDX_F880CAE7F77D927C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier_article AS SELECT panier_id, article_id FROM panier_article');
        $this->addSql('DROP TABLE panier_article');
        $this->addSql('CREATE TABLE panier_article (panier_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(panier_id, article_id), CONSTRAINT FK_F880CAE7F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F880CAE77294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO panier_article (panier_id, article_id) SELECT panier_id, article_id FROM __temp__panier_article');
        $this->addSql('DROP TABLE __temp__panier_article');
        $this->addSql('CREATE INDEX IDX_F880CAE77294869C ON panier_article (article_id)');
        $this->addSql('CREATE INDEX IDX_F880CAE7F77D927C ON panier_article (panier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_24CC0DF279F37AE5');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier AS SELECT id, id_user_id FROM panier');
        $this->addSql('DROP TABLE panier');
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO panier (id, id_user_id) SELECT id, id_user_id FROM __temp__panier');
        $this->addSql('DROP TABLE __temp__panier');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF279F37AE5 ON panier (id_user_id)');
        $this->addSql('DROP INDEX IDX_F880CAE7F77D927C');
        $this->addSql('DROP INDEX IDX_F880CAE77294869C');
        $this->addSql('CREATE TEMPORARY TABLE __temp__panier_article AS SELECT panier_id, article_id FROM panier_article');
        $this->addSql('DROP TABLE panier_article');
        $this->addSql('CREATE TABLE panier_article (panier_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(panier_id, article_id))');
        $this->addSql('INSERT INTO panier_article (panier_id, article_id) SELECT panier_id, article_id FROM __temp__panier_article');
        $this->addSql('DROP TABLE __temp__panier_article');
        $this->addSql('CREATE INDEX IDX_F880CAE7F77D927C ON panier_article (panier_id)');
        $this->addSql('CREATE INDEX IDX_F880CAE77294869C ON panier_article (article_id)');
    }
}
