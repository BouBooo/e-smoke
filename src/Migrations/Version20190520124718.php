<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190520124718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE liquid_capacity (liquid_id INT NOT NULL, capacity_id INT NOT NULL, INDEX IDX_A7AC20613B6CF329 (liquid_id), INDEX IDX_A7AC206166B6F0BA (capacity_id), PRIMARY KEY(liquid_id, capacity_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liquid_dosage (liquid_id INT NOT NULL, dosage_id INT NOT NULL, INDEX IDX_DF0ADBB33B6CF329 (liquid_id), INDEX IDX_DF0ADBB34E8FD016 (dosage_id), PRIMARY KEY(liquid_id, dosage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE liquid_capacity ADD CONSTRAINT FK_A7AC20613B6CF329 FOREIGN KEY (liquid_id) REFERENCES liquid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liquid_capacity ADD CONSTRAINT FK_A7AC206166B6F0BA FOREIGN KEY (capacity_id) REFERENCES capacity (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liquid_dosage ADD CONSTRAINT FK_DF0ADBB33B6CF329 FOREIGN KEY (liquid_id) REFERENCES liquid (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liquid_dosage ADD CONSTRAINT FK_DF0ADBB34E8FD016 FOREIGN KEY (dosage_id) REFERENCES dosage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_liquid DROP quantity');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE liquid_capacity');
        $this->addSql('DROP TABLE liquid_dosage');
        $this->addSql('ALTER TABLE user_liquid ADD quantity INT DEFAULT 1');
    }
}
