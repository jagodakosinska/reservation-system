<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230607101825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_item ADD price_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation_item ADD CONSTRAINT FK_922E876D614C7E7 FOREIGN KEY (price_id) REFERENCES price (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_922E876D614C7E7 ON reservation_item (price_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation_item DROP CONSTRAINT FK_922E876D614C7E7');
        $this->addSql('DROP INDEX IDX_922E876D614C7E7');
        $this->addSql('ALTER TABLE reservation_item DROP price_id');
    }
}
