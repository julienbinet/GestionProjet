<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181015131644 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gest_proj_comment (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, author_id INT NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_FD23B6DF4B89032C (post_id), INDEX IDX_FD23B6DFF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gest_proj_post (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published_at DATETIME NOT NULL, INDEX IDX_758D3450F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gest_proj_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_8CF8F224B89032C (post_id), INDEX IDX_8CF8F22BAD26311 (tag_id), PRIMARY KEY(post_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gest_proj_tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6BADEDBF5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gest_proj_user (id INT AUTO_INCREMENT NOT NULL, full_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_A2948E94F85E0677 (username), UNIQUE INDEX UNIQ_A2948E94E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gest_proj_comment ADD CONSTRAINT FK_FD23B6DF4B89032C FOREIGN KEY (post_id) REFERENCES gest_proj_post (id)');
        $this->addSql('ALTER TABLE gest_proj_comment ADD CONSTRAINT FK_FD23B6DFF675F31B FOREIGN KEY (author_id) REFERENCES gest_proj_user (id)');
        $this->addSql('ALTER TABLE gest_proj_post ADD CONSTRAINT FK_758D3450F675F31B FOREIGN KEY (author_id) REFERENCES gest_proj_user (id)');
        $this->addSql('ALTER TABLE gest_proj_post_tag ADD CONSTRAINT FK_8CF8F224B89032C FOREIGN KEY (post_id) REFERENCES gest_proj_post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE gest_proj_post_tag ADD CONSTRAINT FK_8CF8F22BAD26311 FOREIGN KEY (tag_id) REFERENCES gest_proj_tag (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gest_proj_comment DROP FOREIGN KEY FK_FD23B6DF4B89032C');
        $this->addSql('ALTER TABLE gest_proj_post_tag DROP FOREIGN KEY FK_8CF8F224B89032C');
        $this->addSql('ALTER TABLE gest_proj_post_tag DROP FOREIGN KEY FK_8CF8F22BAD26311');
        $this->addSql('ALTER TABLE gest_proj_comment DROP FOREIGN KEY FK_FD23B6DFF675F31B');
        $this->addSql('ALTER TABLE gest_proj_post DROP FOREIGN KEY FK_758D3450F675F31B');
        $this->addSql('DROP TABLE gest_proj_comment');
        $this->addSql('DROP TABLE gest_proj_post');
        $this->addSql('DROP TABLE gest_proj_post_tag');
        $this->addSql('DROP TABLE gest_proj_tag');
        $this->addSql('DROP TABLE gest_proj_user');
    }
}
