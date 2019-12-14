<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191214010124 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE version (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, telephone_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX IDX_E19D9AD2FE649A29 (telephone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accessoire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephone (id INT AUTO_INCREMENT NOT NULL, modele_id INT NOT NULL, version_id INT NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX IDX_450FF010AC14B70A (modele_id), INDEX IDX_450FF0104BBC2705 (version_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE telephone_accessoire (telephone_id INT NOT NULL, accessoire_id INT NOT NULL, INDEX IDX_6BC8B918FE649A29 (telephone_id), INDEX IDX_6BC8B918D23B67ED (accessoire_id), PRIMARY KEY(telephone_id, accessoire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pro (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, societe VARCHAR(255) NOT NULL, siret INT NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modele (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_par (id INT AUTO_INCREMENT NOT NULL, particulier_id INT NOT NULL, INDEX IDX_6E0DECE4A89E0E67 (particulier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_par_promo (commande_par_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_EAF93BDA44D07D7F (commande_par_id), INDEX IDX_EAF93BDAD0C07AFF (promo_id), PRIMARY KEY(commande_par_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promo (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composant (id INT AUTO_INCREMENT NOT NULL, telephone_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prix INT NOT NULL, INDEX IDX_EC8486C9FE649A29 (telephone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_pro (id INT AUTO_INCREMENT NOT NULL, pro_id INT NOT NULL, INDEX IDX_6CE4C1AFC3B7E4BA (pro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_pro_promo (commande_pro_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_1EC4F01CC1E31F6F (commande_pro_id), INDEX IDX_1EC4F01CD0C07AFF (promo_id), PRIMARY KEY(commande_pro_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_cde_part (id INT AUTO_INCREMENT NOT NULL, commande_par_id INT NOT NULL, INDEX IDX_3850903544D07D7F (commande_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_cde_pro (id INT AUTO_INCREMENT NOT NULL, commande_pro_id INT NOT NULL, INDEX IDX_85D1ACBBC1E31F6F (commande_pro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE particulier (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2FE649A29 FOREIGN KEY (telephone_id) REFERENCES telephone (id)');
        $this->addSql('ALTER TABLE telephone ADD CONSTRAINT FK_450FF010AC14B70A FOREIGN KEY (modele_id) REFERENCES modele (id)');
        $this->addSql('ALTER TABLE telephone ADD CONSTRAINT FK_450FF0104BBC2705 FOREIGN KEY (version_id) REFERENCES version (id)');
        $this->addSql('ALTER TABLE telephone_accessoire ADD CONSTRAINT FK_6BC8B918FE649A29 FOREIGN KEY (telephone_id) REFERENCES telephone (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telephone_accessoire ADD CONSTRAINT FK_6BC8B918D23B67ED FOREIGN KEY (accessoire_id) REFERENCES accessoire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_par ADD CONSTRAINT FK_6E0DECE4A89E0E67 FOREIGN KEY (particulier_id) REFERENCES particulier (id)');
        $this->addSql('ALTER TABLE commande_par_promo ADD CONSTRAINT FK_EAF93BDA44D07D7F FOREIGN KEY (commande_par_id) REFERENCES commande_par (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_par_promo ADD CONSTRAINT FK_EAF93BDAD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE composant ADD CONSTRAINT FK_EC8486C9FE649A29 FOREIGN KEY (telephone_id) REFERENCES telephone (id)');
        $this->addSql('ALTER TABLE commande_pro ADD CONSTRAINT FK_6CE4C1AFC3B7E4BA FOREIGN KEY (pro_id) REFERENCES pro (id)');
        $this->addSql('ALTER TABLE commande_pro_promo ADD CONSTRAINT FK_1EC4F01CC1E31F6F FOREIGN KEY (commande_pro_id) REFERENCES commande_pro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_pro_promo ADD CONSTRAINT FK_1EC4F01CD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_cde_part ADD CONSTRAINT FK_3850903544D07D7F FOREIGN KEY (commande_par_id) REFERENCES commande_par (id)');
        $this->addSql('ALTER TABLE detail_cde_pro ADD CONSTRAINT FK_85D1ACBBC1E31F6F FOREIGN KEY (commande_pro_id) REFERENCES commande_pro (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE telephone DROP FOREIGN KEY FK_450FF0104BBC2705');
        $this->addSql('ALTER TABLE telephone_accessoire DROP FOREIGN KEY FK_6BC8B918D23B67ED');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2FE649A29');
        $this->addSql('ALTER TABLE telephone_accessoire DROP FOREIGN KEY FK_6BC8B918FE649A29');
        $this->addSql('ALTER TABLE composant DROP FOREIGN KEY FK_EC8486C9FE649A29');
        $this->addSql('ALTER TABLE commande_pro DROP FOREIGN KEY FK_6CE4C1AFC3B7E4BA');
        $this->addSql('ALTER TABLE telephone DROP FOREIGN KEY FK_450FF010AC14B70A');
        $this->addSql('ALTER TABLE commande_par_promo DROP FOREIGN KEY FK_EAF93BDA44D07D7F');
        $this->addSql('ALTER TABLE detail_cde_part DROP FOREIGN KEY FK_3850903544D07D7F');
        $this->addSql('ALTER TABLE commande_par_promo DROP FOREIGN KEY FK_EAF93BDAD0C07AFF');
        $this->addSql('ALTER TABLE commande_pro_promo DROP FOREIGN KEY FK_1EC4F01CD0C07AFF');
        $this->addSql('ALTER TABLE commande_pro_promo DROP FOREIGN KEY FK_1EC4F01CC1E31F6F');
        $this->addSql('ALTER TABLE detail_cde_pro DROP FOREIGN KEY FK_85D1ACBBC1E31F6F');
        $this->addSql('ALTER TABLE commande_par DROP FOREIGN KEY FK_6E0DECE4A89E0E67');
        $this->addSql('DROP TABLE version');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE accessoire');
        $this->addSql('DROP TABLE telephone');
        $this->addSql('DROP TABLE telephone_accessoire');
        $this->addSql('DROP TABLE pro');
        $this->addSql('DROP TABLE modele');
        $this->addSql('DROP TABLE commande_par');
        $this->addSql('DROP TABLE commande_par_promo');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE composant');
        $this->addSql('DROP TABLE commande_pro');
        $this->addSql('DROP TABLE commande_pro_promo');
        $this->addSql('DROP TABLE detail_cde_part');
        $this->addSql('DROP TABLE detail_cde_pro');
        $this->addSql('DROP TABLE particulier');
    }
}
