<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427092029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE im22_Basket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E29D4775A76ED395 ON im22_Basket (user_id)');
        $this->addSql('CREATE TABLE im22_BasketProduct (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, basket_id INTEGER NOT NULL, product_id INTEGER NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_E51A927B1BE1FB52 ON im22_BasketProduct (basket_id)');
        $this->addSql('CREATE INDEX IDX_E51A927B4584665A ON im22_BasketProduct (product_id)');
        $this->addSql('CREATE TABLE im22_Product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, price DOUBLE PRECISION DEFAULT NULL, stock INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE im22_User (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9DCF7A97AA08CB10 ON im22_User (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE im22_Basket');
        $this->addSql('DROP TABLE im22_BasketProduct');
        $this->addSql('DROP TABLE im22_Product');
        $this->addSql('DROP TABLE im22_User');
    }
}
