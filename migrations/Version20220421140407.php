<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421140407 extends AbstractMigration
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
        $this->addSql('DROP TABLE panier_auth_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quantity INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE panier_article (id_article INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(id_article, article_id))');
        $this->addSql('CREATE INDEX IDX_F880CAE7DCA7A716 ON panier_article (id_article)');
        $this->addSql('CREATE INDEX IDX_F880CAE77294869C ON panier_article (article_id)');
        $this->addSql('CREATE TABLE panier_auth_user (panier_id INTEGER NOT NULL, auth_user_id INTEGER NOT NULL, PRIMARY KEY(panier_id, auth_user_id))');
        $this->addSql('CREATE INDEX IDX_1D2463E4F77D927C ON panier_auth_user (panier_id)');
        $this->addSql('CREATE INDEX IDX_1D2463E4E94AF366 ON panier_auth_user (auth_user_id)');
    }
}
