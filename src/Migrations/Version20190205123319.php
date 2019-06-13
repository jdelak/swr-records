<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190205123319 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE best_lap (id INT AUTO_INCREMENT NOT NULL, race_id INT NOT NULL, racer_id INT NOT NULL, player_id INT NOT NULL, time VARCHAR(255) NOT NULL, video VARCHAR(255) NOT NULL, crash INT DEFAULT NULL, INDEX IDX_51C624E76E59D40D (race_id), INDEX IDX_51C624E72112FF29 (racer_id), INDEX IDX_51C624E799E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE best_lap ADD CONSTRAINT FK_51C624E76E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE best_lap ADD CONSTRAINT FK_51C624E72112FF29 FOREIGN KEY (racer_id) REFERENCES racer (id)');
        $this->addSql('ALTER TABLE best_lap ADD CONSTRAINT FK_51C624E799E6F5DF FOREIGN KEY (player_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE best_lap');
    }
}
