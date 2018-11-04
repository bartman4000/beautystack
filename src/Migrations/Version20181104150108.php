<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104150108 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE style ADD COLUMN guid CHAR(36) NULL');
        $this->addSql('DROP INDEX IDX_3F8FA755BAD26311');
        $this->addSql('DROP INDEX IDX_3F8FA755BACD6074');
        $this->addSql('CREATE TEMPORARY TABLE __temp__style_tag AS SELECT style_id, tag_id FROM style_tag');
        $this->addSql('DROP TABLE style_tag');
        $this->addSql('CREATE TABLE style_tag (style_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(style_id, tag_id), CONSTRAINT FK_3F8FA755BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_3F8FA755BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO style_tag (style_id, tag_id) SELECT style_id, tag_id FROM __temp__style_tag');
        $this->addSql('DROP TABLE __temp__style_tag');
        $this->addSql('CREATE INDEX IDX_3F8FA755BAD26311 ON style_tag (tag_id)');
        $this->addSql('CREATE INDEX IDX_3F8FA755BACD6074 ON style_tag (style_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__style AS SELECT id, name, description, status, date_created, deleted FROM style');
        $this->addSql('DROP TABLE style');
        $this->addSql('CREATE TABLE style (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, status VARCHAR(100) NOT NULL, date_created DATETIME NOT NULL, deleted BOOLEAN NOT NULL)');
        $this->addSql('INSERT INTO style (id, name, description, status, date_created, deleted) SELECT id, name, description, status, date_created, deleted FROM __temp__style');
        $this->addSql('DROP TABLE __temp__style');
        $this->addSql('DROP INDEX IDX_3F8FA755BACD6074');
        $this->addSql('DROP INDEX IDX_3F8FA755BAD26311');
        $this->addSql('CREATE TEMPORARY TABLE __temp__style_tag AS SELECT style_id, tag_id FROM style_tag');
        $this->addSql('DROP TABLE style_tag');
        $this->addSql('CREATE TABLE style_tag (style_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(style_id, tag_id))');
        $this->addSql('INSERT INTO style_tag (style_id, tag_id) SELECT style_id, tag_id FROM __temp__style_tag');
        $this->addSql('DROP TABLE __temp__style_tag');
        $this->addSql('CREATE INDEX IDX_3F8FA755BACD6074 ON style_tag (style_id)');
        $this->addSql('CREATE INDEX IDX_3F8FA755BAD26311 ON style_tag (tag_id)');
    }
}
