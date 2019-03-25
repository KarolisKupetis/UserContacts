<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190325143658 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE positions (id INT AUTO_INCREMENT NOT NULL, position VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_position (position_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3D6DCF2FDD842E46 (position_id), UNIQUE INDEX UNIQ_3D6DCF2FA76ED395 (user_id), PRIMARY KEY(position_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE users_position ADD CONSTRAINT FK_3D6DCF2FDD842E46 FOREIGN KEY (position_id) REFERENCES positions (id)');
        $this->addSql('ALTER TABLE users_position ADD CONSTRAINT FK_3D6DCF2FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE user_position');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE users_position DROP FOREIGN KEY FK_3D6DCF2FDD842E46');
        $this->addSql('CREATE TABLE user_position (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, position VARCHAR(256) NOT NULL COLLATE utf8_unicode_ci, INDEX IDX_A6A100F5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_position ADD CONSTRAINT FK_A6A100F5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('DROP TABLE positions');
        $this->addSql('DROP TABLE users_position');
    }
}
