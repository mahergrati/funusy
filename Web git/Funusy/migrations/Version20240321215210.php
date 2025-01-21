<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240321215210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_bancaire DROP FOREIGN KEY FK_59E3C22DBFB7B5B6');
        $this->addSql('DROP INDEX IDX_59E3C22DBFB7B5B6 ON carte_bancaire');
        $this->addSql('ALTER TABLE carte_bancaire CHANGE rib rib_id VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE carte_bancaire ADD CONSTRAINT FK_59E3C22D6B253BFF FOREIGN KEY (rib_id) REFERENCES compte (rib) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_59E3C22D6B253BFF ON carte_bancaire (rib_id)');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652606B3CA4B');
        $this->addSql('DROP INDEX fk_user_2 ON compte');
        $this->addSql('CREATE INDEX IDX_CFF652606B3CA4B ON compte (id_user)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652606B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE credit DROP FOREIGN KEY fk_user_credit');
        $this->addSql('DROP INDEX fk_user_credit ON credit');
        $this->addSql('ALTER TABLE credit DROP id_user');
        $this->addSql('ALTER TABLE echeance CHANGE numero numero INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX id_credit ON garantie');
        $this->addSql('DROP INDEX IDX_75EA56E0E3BD61CE ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E016BA31DB ON messenger_messages');
        $this->addSql('DROP INDEX IDX_75EA56E0FB7336F0 ON messenger_messages');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY fk_user_projet');
        $this->addSql('ALTER TABLE projet CHANGE id_user id_user INT DEFAULT NULL');
        $this->addSql('DROP INDEX fk_user_projet ON projet');
        $this->addSql('CREATE INDEX IDX_50159CA96B3CA4B ON projet (id_user)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT fk_user_projet FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY fk_commentaire');
        $this->addSql('ALTER TABLE signale CHANGE id_commentaire id_commentaire INT DEFAULT NULL');
        $this->addSql('DROP INDEX fk_commentaire ON signale');
        $this->addSql('CREATE INDEX IDX_2279705C7FE2A54B ON signale (id_commentaire)');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT fk_commentaire FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY fk_rib_tran');
        $this->addSql('ALTER TABLE transaction CHANGE rib rib VARCHAR(20) DEFAULT NULL');
        $this->addSql('DROP INDEX fk_rib_tran ON transaction');
        $this->addSql('CREATE INDEX IDX_723705D1BFB7B5B6 ON transaction (rib)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT fk_rib_tran FOREIGN KEY (rib) REFERENCES compte (rib)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_bancaire DROP FOREIGN KEY FK_59E3C22D6B253BFF');
        $this->addSql('DROP INDEX UNIQ_59E3C22D6B253BFF ON carte_bancaire');
        $this->addSql('ALTER TABLE carte_bancaire CHANGE rib_id rib VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE carte_bancaire ADD CONSTRAINT FK_59E3C22DBFB7B5B6 FOREIGN KEY (rib) REFERENCES compte (rib)');
        $this->addSql('CREATE INDEX IDX_59E3C22DBFB7B5B6 ON carte_bancaire (rib)');
        $this->addSql('ALTER TABLE compte DROP FOREIGN KEY FK_CFF652606B3CA4B');
        $this->addSql('DROP INDEX idx_cff652606b3ca4b ON compte');
        $this->addSql('CREATE INDEX fk_user_2 ON compte (id_user)');
        $this->addSql('ALTER TABLE compte ADD CONSTRAINT FK_CFF652606B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE credit ADD id_user INT NOT NULL');
        $this->addSql('ALTER TABLE credit ADD CONSTRAINT fk_user_credit FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('CREATE INDEX fk_user_credit ON credit (id_user)');
        $this->addSql('ALTER TABLE echeance CHANGE numero numero INT NOT NULL');
        $this->addSql('CREATE INDEX id_credit ON garantie (id_credit)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('ALTER TABLE projet DROP FOREIGN KEY FK_50159CA96B3CA4B');
        $this->addSql('ALTER TABLE projet CHANGE id_user id_user INT NOT NULL');
        $this->addSql('DROP INDEX idx_50159ca96b3ca4b ON projet');
        $this->addSql('CREATE INDEX fk_user_projet ON projet (id_user)');
        $this->addSql('ALTER TABLE projet ADD CONSTRAINT FK_50159CA96B3CA4B FOREIGN KEY (id_user) REFERENCES user (id_user)');
        $this->addSql('ALTER TABLE signale DROP FOREIGN KEY FK_2279705C7FE2A54B');
        $this->addSql('ALTER TABLE signale CHANGE id_commentaire id_commentaire INT NOT NULL');
        $this->addSql('DROP INDEX idx_2279705c7fe2a54b ON signale');
        $this->addSql('CREATE INDEX fk_commentaire ON signale (id_commentaire)');
        $this->addSql('ALTER TABLE signale ADD CONSTRAINT FK_2279705C7FE2A54B FOREIGN KEY (id_commentaire) REFERENCES commentaire (id_commentaire)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1BFB7B5B6');
        $this->addSql('ALTER TABLE transaction CHANGE rib rib VARCHAR(20) NOT NULL');
        $this->addSql('DROP INDEX idx_723705d1bfb7b5b6 ON transaction');
        $this->addSql('CREATE INDEX fk_rib_tran ON transaction (rib)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1BFB7B5B6 FOREIGN KEY (rib) REFERENCES compte (rib)');
    }
}
