<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326065238 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE phone_numbers (id INT AUTO_INCREMENT NOT NULL, phone_number VARCHAR(256) NOT NULL, userContacts_id INT DEFAULT NULL, INDEX IDX_E7DC46CB332F0DCD (userContacts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE phone_numbers ADD CONSTRAINT FK_E7DC46CB332F0DCD FOREIGN KEY (userContacts_id) REFERENCES user_contacts (id)');
        $this->addSql('ALTER TABLE user_contacts DROP phone_number');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE phone_numbers');
        $this->addSql('ALTER TABLE user_contacts ADD phone_number VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci');
    }
}
