<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190825211657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE SPAs_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE treatments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE customers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE operators_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE SPAs (id INT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, address VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE treatments (id INT NOT NULL, spa_id INT NOT NULL, name VARCHAR(255) NOT NULL, price float NOT NULL, duration INT NOT NULL, vat DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4A48CE0DDF3CB247 ON treatments (spa_id)');
        $this->addSql('COMMENT ON COLUMN treatments.price IS \'(DC2Type:money_type)\'');
        $this->addSql('CREATE TABLE treatment_operator (treatment_id INT NOT NULL, operator_id INT NOT NULL, PRIMARY KEY(treatment_id, operator_id))');
        $this->addSql('CREATE INDEX IDX_450CEFD8471C0366 ON treatment_operator (treatment_id)');
        $this->addSql('CREATE INDEX IDX_450CEFD8584598A3 ON treatment_operator (operator_id)');
        $this->addSql('CREATE TABLE reservations (id INT NOT NULL, treatment_id INT NOT NULL, customer_id INT NOT NULL, spa_id INT NOT NULL, operator_id INT NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, duration INT NOT NULL, price float NOT NULL, vat DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4DA239471C0366 ON reservations (treatment_id)');
        $this->addSql('CREATE INDEX IDX_4DA2399395C3F3 ON reservations (customer_id)');
        $this->addSql('CREATE INDEX IDX_4DA239DF3CB247 ON reservations (spa_id)');
        $this->addSql('CREATE INDEX IDX_4DA239584598A3 ON reservations (operator_id)');
        $this->addSql('COMMENT ON COLUMN reservations.start_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reservations.end_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reservations.price IS \'(DC2Type:money_type)\'');
        $this->addSql('CREATE TABLE customers (id INT NOT NULL, spa_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62534E21DF3CB247 ON customers (spa_id)');
        $this->addSql('COMMENT ON COLUMN customers.birthday IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, spa_id INT DEFAULT NULL, name VARCHAR(45) NOT NULL, last_name VARCHAR(45) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1483A5E9DF3CB247 ON users (spa_id)');
        $this->addSql('CREATE TABLE operators (id INT NOT NULL, spa_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, phone_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8166DA1ADF3CB247 ON operators (spa_id)');
        $this->addSql('ALTER TABLE treatments ADD CONSTRAINT FK_4A48CE0DDF3CB247 FOREIGN KEY (spa_id) REFERENCES SPAs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE treatment_operator ADD CONSTRAINT FK_450CEFD8471C0366 FOREIGN KEY (treatment_id) REFERENCES treatments (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE treatment_operator ADD CONSTRAINT FK_450CEFD8584598A3 FOREIGN KEY (operator_id) REFERENCES operators (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239471C0366 FOREIGN KEY (treatment_id) REFERENCES treatments (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA2399395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239DF3CB247 FOREIGN KEY (spa_id) REFERENCES SPAs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239584598A3 FOREIGN KEY (operator_id) REFERENCES operators (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E21DF3CB247 FOREIGN KEY (spa_id) REFERENCES SPAs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9DF3CB247 FOREIGN KEY (spa_id) REFERENCES SPAs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE operators ADD CONSTRAINT FK_8166DA1ADF3CB247 FOREIGN KEY (spa_id) REFERENCES SPAs (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE treatments DROP CONSTRAINT FK_4A48CE0DDF3CB247');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA239DF3CB247');
        $this->addSql('ALTER TABLE customers DROP CONSTRAINT FK_62534E21DF3CB247');
        $this->addSql('ALTER TABLE users DROP CONSTRAINT FK_1483A5E9DF3CB247');
        $this->addSql('ALTER TABLE operators DROP CONSTRAINT FK_8166DA1ADF3CB247');
        $this->addSql('ALTER TABLE treatment_operator DROP CONSTRAINT FK_450CEFD8471C0366');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA239471C0366');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA2399395C3F3');
        $this->addSql('ALTER TABLE treatment_operator DROP CONSTRAINT FK_450CEFD8584598A3');
        $this->addSql('ALTER TABLE reservations DROP CONSTRAINT FK_4DA239584598A3');
        $this->addSql('DROP SEQUENCE SPAs_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE treatments_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE customers_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE operators_id_seq CASCADE');
        $this->addSql('DROP TABLE SPAs');
        $this->addSql('DROP TABLE treatments');
        $this->addSql('DROP TABLE treatment_operator');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE customers');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE operators');
    }
}
