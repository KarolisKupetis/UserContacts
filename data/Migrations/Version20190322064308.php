<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190322064308 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_position (id INT AUTO_INCREMENT NOT NULL, user_contacts_id INT DEFAULT NULL, position VARCHAR(256) NOT NULL, INDEX IDX_A6A100F5D8847D1B (user_contacts_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_position ADD CONSTRAINT FK_A6A100F5D8847D1B FOREIGN KEY (user_contacts_id) REFERENCES user_contacts (id)');
        $this->addSql('ALTER TABLE user_contacts ADD positions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user_contacts ADD CONSTRAINT FK_D3CDF1737813DDAE FOREIGN KEY (positions_id) REFERENCES user_position (id)');
        $this->addSql('CREATE INDEX IDX_D3CDF1737813DDAE ON user_contacts (positions_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_contacts DROP FOREIGN KEY FK_D3CDF1737813DDAE');
        $this->addSql('DROP TABLE user_position');
        $this->addSql('DROP INDEX IDX_D3CDF1737813DDAE ON user_contacts');
        $this->addSql('ALTER TABLE user_contacts DROP positions_id');
    }
}
