<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115180000_CreateInitialTables extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE champion (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E6A5A63989D9B62 ON champion (slug)');
        $this->addSql('CREATE TABLE category (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, slug VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1989D9B62 ON category (slug)');
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(100) NOT NULL, bio TEXT DEFAULT NULL, avatar_url VARCHAR(255) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE TABLE skin (id UUID NOT NULL, seller_id UUID NOT NULL, champion_id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT NOT NULL, price INT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, cover_image VARCHAR(255) DEFAULT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3B3F8E744A5E91E7 ON skin (seller_id)');
        $this->addSql('CREATE INDEX IDX_3B3F8E74C7440455 ON skin (champion_id)');
        $this->addSql('CREATE TABLE "order" (id UUID NOT NULL, buyer_id UUID NOT NULL, reference VARCHAR(20) NOT NULL, total_price INT NOT NULL, status VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2F3A5B4E4E6A5A649E7927C74 ON "order" (reference)');
        $this->addSql('CREATE INDEX IDX_2F3A5B4E4E6A5A64 ON "order" (buyer_id)');
        $this->addSql('CREATE TABLE order_item (id SERIAL NOT NULL, order_id UUID NOT NULL, skin_id UUID NOT NULL, price_at_purchase INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_52EA1F098D9F6D38 ON order_item (order_id)');
        $this->addSql('CREATE INDEX IDX_52EA1F0945C463B8 ON order_item (skin_id)');
        $this->addSql('CREATE TABLE skin_category (skin_id UUID NOT NULL, category_id INT NOT NULL, PRIMARY KEY(skin_id, category_id))');
        $this->addSql('CREATE INDEX IDX_8C9B363C45C463B8 ON skin_category (skin_id)');
        $this->addSql('CREATE INDEX IDX_8C9B363C12469DE2 ON skin_category (category_id)');
        $this->addSql('ALTER TABLE skin ADD CONSTRAINT FK_3B3F8E744A5E91E7 FOREIGN KEY (seller_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skin ADD CONSTRAINT FK_3B3F8E74C7440455 FOREIGN KEY (champion_id) REFERENCES champion (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order" ADD CONSTRAINT FK_2F3A5B4E4E6A5A64 FOREIGN KEY (buyer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F098D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F0945C463B8 FOREIGN KEY (skin_id) REFERENCES skin (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skin_category ADD CONSTRAINT FK_8C9B363C45C463B8 FOREIGN KEY (skin_id) REFERENCES skin (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE skin_category ADD CONSTRAINT FK_8C9B363C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skin_category DROP CONSTRAINT FK_8C9B363C12469DE2');
        $this->addSql('ALTER TABLE skin_category DROP CONSTRAINT FK_8C9B363C45C463B8');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F0945C463B8');
        $this->addSql('ALTER TABLE order_item DROP CONSTRAINT FK_52EA1F098D9F6D38');
        $this->addSql('ALTER TABLE "order" DROP CONSTRAINT FK_2F3A5B4E4E6A5A64');
        $this->addSql('ALTER TABLE skin DROP CONSTRAINT FK_3B3F8E74C7440455');
        $this->addSql('ALTER TABLE skin DROP CONSTRAINT FK_3B3F8E744A5E91E7');
        $this->addSql('DROP TABLE skin_category');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE skin');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE champion');
    }
}
