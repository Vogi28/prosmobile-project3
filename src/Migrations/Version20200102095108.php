<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200102095108 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE version ADD photo LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE service ADD photo LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE accessoire ADD photo LONGTEXT DEFAULT NULL, ADD reference VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE telephone ADD photo LONGTEXT DEFAULT NULL, ADD reference VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE modele ADD photo LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD photo LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE composant ADD photo LONGTEXT DEFAULT NULL, ADD reference VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accessoire DROP photo, DROP reference');
        $this->addSql('ALTER TABLE composant DROP photo, DROP reference');
        $this->addSql('ALTER TABLE modele DROP photo');
        $this->addSql('ALTER TABLE promo DROP photo');
        $this->addSql('ALTER TABLE service DROP photo');
        $this->addSql('ALTER TABLE telephone DROP photo, DROP reference');
        $this->addSql('ALTER TABLE version DROP photo');
    }
}
