<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250929091555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chat (id SERIAL NOT NULL, user1_id_id INT DEFAULT NULL, user2_id_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_659DF2AA4BA75E4E ON chat (user1_id_id)');
        $this->addSql('CREATE INDEX IDX_659DF2AA7A4F44D3 ON chat (user2_id_id)');
        $this->addSql('COMMENT ON COLUMN chat.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE demands (id SERIAL NOT NULL, locator_id INT NOT NULL, owner_id INT NOT NULL, logement_id INT NOT NULL, type VARCHAR(255) NOT NULL, content VARCHAR(255) NOT NULL, status VARCHAR(60) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D24062F4BC9F98A ON demands (locator_id)');
        $this->addSql('CREATE INDEX IDX_D24062F47E3C61F9 ON demands (owner_id)');
        $this->addSql('CREATE INDEX IDX_D24062F458ABF955 ON demands (logement_id)');
        $this->addSql('COMMENT ON COLUMN demands.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE favoris (id SERIAL NOT NULL, user_id INT NOT NULL, logement_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8933C432A76ED395 ON favoris (user_id)');
        $this->addSql('CREATE INDEX IDX_8933C43258ABF955 ON favoris (logement_id)');
        $this->addSql('CREATE UNIQUE INDEX unique_user_logement ON favoris (user_id, logement_id)');
        $this->addSql('CREATE TABLE logement (id SERIAL NOT NULL, owner_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0FD44577E3C61F9 ON logement (owner_id)');
        $this->addSql('COMMENT ON COLUMN logement.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE logement_user (logement_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(logement_id, user_id))');
        $this->addSql('CREATE INDEX IDX_E7537BDD58ABF955 ON logement_user (logement_id)');
        $this->addSql('CREATE INDEX IDX_E7537BDDA76ED395 ON logement_user (user_id)');
        $this->addSql('CREATE TABLE message (id SERIAL NOT NULL, chat_id INT NOT NULL, sender_id INT NOT NULL, content VARCHAR(255) NOT NULL, sent_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6BD307F1A9A7125 ON message (chat_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('COMMENT ON COLUMN message.sent_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE photos (id SERIAL NOT NULL, logement_id INT DEFAULT NULL, source VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_876E0D958ABF955 ON photos (logement_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(20) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA4BA75E4E FOREIGN KEY (user1_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA7A4F44D3 FOREIGN KEY (user2_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demands ADD CONSTRAINT FK_D24062F4BC9F98A FOREIGN KEY (locator_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demands ADD CONSTRAINT FK_D24062F47E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE demands ADD CONSTRAINT FK_D24062F458ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C432A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE favoris ADD CONSTRAINT FK_8933C43258ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD44577E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE logement_user ADD CONSTRAINT FK_E7537BDD58ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE logement_user ADD CONSTRAINT FK_E7537BDDA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F1A9A7125 FOREIGN KEY (chat_id) REFERENCES chat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D958ABF955 FOREIGN KEY (logement_id) REFERENCES logement (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE chat DROP CONSTRAINT FK_659DF2AA4BA75E4E');
        $this->addSql('ALTER TABLE chat DROP CONSTRAINT FK_659DF2AA7A4F44D3');
        $this->addSql('ALTER TABLE demands DROP CONSTRAINT FK_D24062F4BC9F98A');
        $this->addSql('ALTER TABLE demands DROP CONSTRAINT FK_D24062F47E3C61F9');
        $this->addSql('ALTER TABLE demands DROP CONSTRAINT FK_D24062F458ABF955');
        $this->addSql('ALTER TABLE favoris DROP CONSTRAINT FK_8933C432A76ED395');
        $this->addSql('ALTER TABLE favoris DROP CONSTRAINT FK_8933C43258ABF955');
        $this->addSql('ALTER TABLE logement DROP CONSTRAINT FK_F0FD44577E3C61F9');
        $this->addSql('ALTER TABLE logement_user DROP CONSTRAINT FK_E7537BDD58ABF955');
        $this->addSql('ALTER TABLE logement_user DROP CONSTRAINT FK_E7537BDDA76ED395');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307F1A9A7125');
        $this->addSql('ALTER TABLE message DROP CONSTRAINT FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE photos DROP CONSTRAINT FK_876E0D958ABF955');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE demands');
        $this->addSql('DROP TABLE favoris');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE logement_user');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE "user"');
    }
}
