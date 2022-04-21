<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421142743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE panier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_user_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF279F37AE5 ON panier (id_user_id)');
        $this->addSql('CREATE TABLE panier_article (panier_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(panier_id, article_id))');
        $this->addSql('CREATE INDEX IDX_F880CAE7F77D927C ON panier_article (panier_id)');
        $this->addSql('CREATE INDEX IDX_F880CAE77294869C ON panier_article (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE panier_article');
    }
}
