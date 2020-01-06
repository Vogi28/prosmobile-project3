<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200106111547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE art_comp (id INT AUTO_INCREMENT NOT NULL, art_id INT NOT NULL, art_comp_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_par_promo (commande_par_id INT NOT NULL, promo_id INT NOT NULL, INDEX IDX_EAF93BDA44D07D7F (commande_par_id), INDEX IDX_EAF93BDAD0C07AFF (promo_id), PRIMARY KEY(commande_par_id, promo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, type_art_id INT NOT NULL, nom VARCHAR(255) NOT NULL, photo LONGTEXT DEFAULT NULL, reference VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, prix_ht INT NOT NULL, prix_ttc INT NOT NULL, stock INT NOT NULL, relation INT NOT NULL, INDEX IDX_23A0E66AFF28E22 (type_art_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_spec (article_id INT NOT NULL, spec_id INT NOT NULL, INDEX IDX_704C903F7294869C (article_id), INDEX IDX_704C903FAA8FA4FB (spec_id), PRIMARY KEY(article_id, spec_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_art (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spec (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, id_groupe INT NOT NULL, valeur VARCHAR(255) NOT NULL, unite VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_cde_part (id INT AUTO_INCREMENT NOT NULL, commande_par_id INT NOT NULL, nom_art VARCHAR(255) NOT NULL, quantite INT NOT NULL, prix_ht INT NOT NULL, prix_ttc INT NOT NULL, promo INT DEFAULT NULL, total INT NOT NULL, INDEX IDX_3850903544D07D7F (commande_par_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_cde_part_article (detail_cde_part_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_C9483F8E5ECB399D (detail_cde_part_id), INDEX IDX_C9483F8E7294869C (article_id), PRIMARY KEY(detail_cde_part_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_cde_pro (id INT AUTO_INCREMENT NOT NULL, commande_pro_id INT NOT NULL, nom_art VARCHAR(255) NOT NULL, quantite INT NOT NULL, prix_ht INT NOT NULL, remise INT NOT NULL, total INT NOT NULL, INDEX IDX_85D1ACBBC1E31F6F (commande_pro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_cde_pro_article (detail_cde_pro_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_DD816C985C2CC5E3 (detail_cde_pro_id), INDEX IDX_DD816C987294869C (article_id), PRIMARY KEY(detail_cde_pro_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_par_promo ADD CONSTRAINT FK_EAF93BDA44D07D7F FOREIGN KEY (commande_par_id) REFERENCES commande_par (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande_par_promo ADD CONSTRAINT FK_EAF93BDAD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66AFF28E22 FOREIGN KEY (type_art_id) REFERENCES type_art (id)');
        $this->addSql('ALTER TABLE article_spec ADD CONSTRAINT FK_704C903F7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_spec ADD CONSTRAINT FK_704C903FAA8FA4FB FOREIGN KEY (spec_id) REFERENCES spec (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_cde_part ADD CONSTRAINT FK_3850903544D07D7F FOREIGN KEY (commande_par_id) REFERENCES commande_par (id)');
        $this->addSql('ALTER TABLE detail_cde_part_article ADD CONSTRAINT FK_C9483F8E5ECB399D FOREIGN KEY (detail_cde_part_id) REFERENCES detail_cde_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_cde_part_article ADD CONSTRAINT FK_C9483F8E7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_cde_pro ADD CONSTRAINT FK_85D1ACBBC1E31F6F FOREIGN KEY (commande_pro_id) REFERENCES commande_pro (id)');
        $this->addSql('ALTER TABLE detail_cde_pro_article ADD CONSTRAINT FK_DD816C985C2CC5E3 FOREIGN KEY (detail_cde_pro_id) REFERENCES detail_cde_pro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detail_cde_pro_article ADD CONSTRAINT FK_DD816C987294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article_spec DROP FOREIGN KEY FK_704C903F7294869C');
        $this->addSql('ALTER TABLE detail_cde_part_article DROP FOREIGN KEY FK_C9483F8E7294869C');
        $this->addSql('ALTER TABLE detail_cde_pro_article DROP FOREIGN KEY FK_DD816C987294869C');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66AFF28E22');
        $this->addSql('ALTER TABLE article_spec DROP FOREIGN KEY FK_704C903FAA8FA4FB');
        $this->addSql('ALTER TABLE detail_cde_part_article DROP FOREIGN KEY FK_C9483F8E5ECB399D');
        $this->addSql('ALTER TABLE detail_cde_pro_article DROP FOREIGN KEY FK_DD816C985C2CC5E3');
        $this->addSql('DROP TABLE art_comp');
        $this->addSql('DROP TABLE commande_par_promo');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_spec');
        $this->addSql('DROP TABLE type_art');
        $this->addSql('DROP TABLE spec');
        $this->addSql('DROP TABLE detail_cde_part');
        $this->addSql('DROP TABLE detail_cde_part_article');
        $this->addSql('DROP TABLE detail_cde_pro');
        $this->addSql('DROP TABLE detail_cde_pro_article');
    }
}
