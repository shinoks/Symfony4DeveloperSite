<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180219130023 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offer ADD status_id INT DEFAULT NULL, DROP status');
        $this->addSql('ALTER TABLE offer ADD CONSTRAINT FK_29D6873E6BF700BD FOREIGN KEY (status_id) REFERENCES offer_status (id)');
        $this->addSql('CREATE INDEX IDX_29D6873E6BF700BD ON offer (status_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offer DROP FOREIGN KEY FK_29D6873E6BF700BD');
        $this->addSql('DROP INDEX IDX_29D6873E6BF700BD ON offer');
        $this->addSql('ALTER TABLE offer ADD status VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, DROP status_id');
    }
}
