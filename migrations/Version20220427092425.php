<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427092425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E29D4775A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im22_Basket AS SELECT id, user_id FROM im22_Basket');
        $this->addSql('DROP TABLE im22_Basket');
        $this->addSql('CREATE TABLE im22_Basket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_E29D4775A76ED395 FOREIGN KEY (user_id) REFERENCES im22_User (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO im22_Basket (id, user_id) SELECT id, user_id FROM __temp__im22_Basket');
        $this->addSql('DROP TABLE __temp__im22_Basket');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E29D4775A76ED395 ON im22_Basket (user_id)');
        $this->addSql('DROP INDEX IDX_E51A927B4584665A');
        $this->addSql('DROP INDEX IDX_E51A927B1BE1FB52');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im22_BasketProduct AS SELECT id, basket_id, product_id, quantity FROM im22_BasketProduct');
        $this->addSql('DROP TABLE im22_BasketProduct');
        $this->addSql('CREATE TABLE im22_BasketProduct (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, basket_id INTEGER NOT NULL, product_id INTEGER NOT NULL, quantity INTEGER NOT NULL, CONSTRAINT FK_E51A927B1BE1FB52 FOREIGN KEY (basket_id) REFERENCES im22_Basket (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_E51A927B4584665A FOREIGN KEY (product_id) REFERENCES im22_Product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO im22_BasketProduct (id, basket_id, product_id, quantity) SELECT id, basket_id, product_id, quantity FROM __temp__im22_BasketProduct');
        $this->addSql('DROP TABLE __temp__im22_BasketProduct');
        $this->addSql('CREATE INDEX IDX_E51A927B4584665A ON im22_BasketProduct (product_id)');
        $this->addSql('CREATE INDEX IDX_E51A927B1BE1FB52 ON im22_BasketProduct (basket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_E29D4775A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im22_Basket AS SELECT id, user_id FROM im22_Basket');
        $this->addSql('DROP TABLE im22_Basket');
        $this->addSql('CREATE TABLE im22_Basket (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO im22_Basket (id, user_id) SELECT id, user_id FROM __temp__im22_Basket');
        $this->addSql('DROP TABLE __temp__im22_Basket');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E29D4775A76ED395 ON im22_Basket (user_id)');
        $this->addSql('DROP INDEX IDX_E51A927B1BE1FB52');
        $this->addSql('DROP INDEX IDX_E51A927B4584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__im22_BasketProduct AS SELECT id, basket_id, product_id, quantity FROM im22_BasketProduct');
        $this->addSql('DROP TABLE im22_BasketProduct');
        $this->addSql('CREATE TABLE im22_BasketProduct (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, basket_id INTEGER NOT NULL, product_id INTEGER NOT NULL, quantity INTEGER NOT NULL)');
        $this->addSql('INSERT INTO im22_BasketProduct (id, basket_id, product_id, quantity) SELECT id, basket_id, product_id, quantity FROM __temp__im22_BasketProduct');
        $this->addSql('DROP TABLE __temp__im22_BasketProduct');
        $this->addSql('CREATE INDEX IDX_E51A927B1BE1FB52 ON im22_BasketProduct (basket_id)');
        $this->addSql('CREATE INDEX IDX_E51A927B4584665A ON im22_BasketProduct (product_id)');
    }
}
