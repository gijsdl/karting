<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210318105324 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE activiteiten (id INT AUTO_INCREMENT NOT NULL, soort_id INT NOT NULL, datum DATE NOT NULL, tijd TIME NOT NULL, INDEX IDX_1C50895F3DEE50DF (soort_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, email VARCHAR(60) NOT NULL, voorletters VARCHAR(10) NOT NULL, tussenvoegsel VARCHAR(10) DEFAULT NULL, achternaam VARCHAR(25) NOT NULL, adres VARCHAR(25) NOT NULL, postcode VARCHAR(7) NOT NULL, woonplaats VARCHAR(20) NOT NULL, telefoon VARCHAR(15) NOT NULL, UNIQUE INDEX UNIQ_C2502824F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users_activiteiten (app_users_id INT NOT NULL, activiteiten_id INT NOT NULL, INDEX IDX_2F05642B6F33D490 (app_users_id), INDEX IDX_2F05642B808BDE57 (activiteiten_id), PRIMARY KEY(app_users_id, activiteiten_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE soort_activiteiten (id INT AUTO_INCREMENT NOT NULL, naam VARCHAR(255) NOT NULL, min_leeftijd INT NOT NULL, tijdsduur INT NOT NULL, prijs NUMERIC(6, 2) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE activiteiten ADD CONSTRAINT FK_1C50895F3DEE50DF FOREIGN KEY (soort_id) REFERENCES soort_activiteiten (id)');
        $this->addSql('ALTER TABLE app_users_activiteiten ADD CONSTRAINT FK_2F05642B6F33D490 FOREIGN KEY (app_users_id) REFERENCES app_users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE app_users_activiteiten ADD CONSTRAINT FK_2F05642B808BDE57 FOREIGN KEY (activiteiten_id) REFERENCES activiteiten (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_users_activiteiten DROP FOREIGN KEY FK_2F05642B808BDE57');
        $this->addSql('ALTER TABLE app_users_activiteiten DROP FOREIGN KEY FK_2F05642B6F33D490');
        $this->addSql('ALTER TABLE activiteiten DROP FOREIGN KEY FK_1C50895F3DEE50DF');
        $this->addSql('DROP TABLE activiteiten');
        $this->addSql('DROP TABLE app_users');
        $this->addSql('DROP TABLE app_users_activiteiten');
        $this->addSql('DROP TABLE soort_activiteiten');
    }
}
