<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181016081356 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE gest_proj_projet (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, date_debut DATE DEFAULT NULL, date_fin DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gest_proj_tache (id INT AUTO_INCREMENT NOT NULL, projet_id INT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, jour DATE NOT NULL, duree TIME DEFAULT NULL, INDEX IDX_6BCA8944C18272 (projet_id), INDEX IDX_6BCA8944A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gest_proj_tache ADD CONSTRAINT FK_6BCA8944C18272 FOREIGN KEY (projet_id) REFERENCES gest_proj_projet (id)');
        $this->addSql('ALTER TABLE gest_proj_tache ADD CONSTRAINT FK_6BCA8944A76ED395 FOREIGN KEY (user_id) REFERENCES gest_proj_user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE gest_proj_tache DROP FOREIGN KEY FK_6BCA8944C18272');
        $this->addSql('DROP TABLE gest_proj_projet');
        $this->addSql('DROP TABLE gest_proj_tache');
    }
}
