<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104162219 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, tag FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tag VARCHAR(100) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO tag (id, tag) SELECT id, tag FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_389B783389B783 ON tag (tag)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__style AS SELECT id, name, description, status, date_created, deleted, guid FROM style');
        $this->addSql('DROP TABLE style');
        $this->addSql('CREATE TABLE style (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description CLOB DEFAULT NULL COLLATE BINARY, date_created DATETIME NOT NULL, deleted BOOLEAN NOT NULL, guid CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:guid)
        , name VARCHAR(255) NOT NULL, status VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO style (id, name, description, status, date_created, deleted, guid) SELECT id, name, description, status, date_created, deleted, guid FROM __temp__style');
        $this->addSql('DROP TABLE __temp__style');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_33BDB86A2B6FCFB2 ON style (guid)');
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

        $this->addSql('DROP INDEX UNIQ_33BDB86A2B6FCFB2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__style AS SELECT id, name, description, status, date_created, deleted, guid FROM style');
        $this->addSql('DROP TABLE style');
        $this->addSql('CREATE TABLE style (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, description CLOB DEFAULT NULL, date_created DATETIME NOT NULL, deleted BOOLEAN NOT NULL, guid CHAR(36) NOT NULL --(DC2Type:guid)
        , name CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:guid)
        , status CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:guid)
        )');
        $this->addSql('INSERT INTO style (id, name, description, status, date_created, deleted, guid) SELECT id, name, description, status, date_created, deleted, guid FROM __temp__style');
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
        $this->addSql('DROP INDEX UNIQ_389B783389B783');
        $this->addSql('CREATE TEMPORARY TABLE __temp__tag AS SELECT id, tag FROM tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, tag VARCHAR(100) NOT NULL)');
        $this->addSql('INSERT INTO tag (id, tag) SELECT id, tag FROM __temp__tag');
        $this->addSql('DROP TABLE __temp__tag');
    }
}
