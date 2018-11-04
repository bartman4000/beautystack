<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104131440 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tag VARCHAR(100) NOT NULL)');
        $this->addSql('CREATE TABLE style (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, status VARCHAR(100) NOT NULL, date_created DATETIME NOT NULL, deleted BOOLEAN NOT NULL)');
        $this->addSql('CREATE TABLE style_tag (style_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(style_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_3F8FA755BACD6074 ON style_tag (style_id)');
        $this->addSql('CREATE INDEX IDX_3F8FA755BAD26311 ON style_tag (tag_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE style_tag');
    }
}
