<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180511171010 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE atelier (id INT AUTO_INCREMENT NOT NULL, libelle_atelier VARCHAR(255) NOT NULL, nb_places_maxi INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE atelier_avis (id INT AUTO_INCREMENT NOT NULL, atelier_id INT NOT NULL, avis_id INT NOT NULL, quantite INT NOT NULL, INDEX IDX_4F16221382E2CF35 (atelier_id), INDEX IDX_4F162213197E709F (avis_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (id INT AUTO_INCREMENT NOT NULL, libelle_avis VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE atelier_avis ADD CONSTRAINT FK_4F16221382E2CF35 FOREIGN KEY (atelier_id) REFERENCES atelier (id)');
        $this->addSql('ALTER TABLE atelier_avis ADD CONSTRAINT FK_4F162213197E709F FOREIGN KEY (avis_id) REFERENCES avis (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE atelier_avis DROP FOREIGN KEY FK_4F16221382E2CF35');
        $this->addSql('ALTER TABLE atelier_avis DROP FOREIGN KEY FK_4F162213197E709F');
        $this->addSql('DROP TABLE atelier');
        $this->addSql('DROP TABLE atelier_avis');
        $this->addSql('DROP TABLE avis');
    }
}
