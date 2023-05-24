<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230524124901 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE schedule_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE screen_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE seat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE reservation (id INT NOT NULL, schedule_id INT NOT NULL, status VARCHAR(255) NOT NULL, total_price DOUBLE PRECISION NOT NULL, valid_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C84955A40BC2D5 ON reservation (schedule_id)');
        $this->addSql('CREATE TABLE reservation_item (id INT NOT NULL, reservation_id INT NOT NULL, seat_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_922E876B83297E7 ON reservation_item (reservation_id)');
        $this->addSql('CREATE INDEX IDX_922E876C1DAFE35 ON reservation_item (seat_id)');
        $this->addSql('CREATE TABLE schedule (id INT NOT NULL, screen_id INT NOT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5A3811FB41A67722 ON schedule (screen_id)');
        $this->addSql('CREATE TABLE screen (id INT NOT NULL, name VARCHAR(255) NOT NULL, number_of_seats INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE seat (id INT NOT NULL, screen_id INT NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3D5C366641A67722 ON seat (screen_id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation_item ADD CONSTRAINT FK_922E876B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE reservation_item ADD CONSTRAINT FK_922E876C1DAFE35 FOREIGN KEY (seat_id) REFERENCES seat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB41A67722 FOREIGN KEY (screen_id) REFERENCES screen (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE seat ADD CONSTRAINT FK_3D5C366641A67722 FOREIGN KEY (screen_id) REFERENCES screen (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE schedule_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE screen_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE seat_id_seq CASCADE');
        $this->addSql('ALTER TABLE reservation DROP CONSTRAINT FK_42C84955A40BC2D5');
        $this->addSql('ALTER TABLE reservation_item DROP CONSTRAINT FK_922E876B83297E7');
        $this->addSql('ALTER TABLE reservation_item DROP CONSTRAINT FK_922E876C1DAFE35');
        $this->addSql('ALTER TABLE schedule DROP CONSTRAINT FK_5A3811FB41A67722');
        $this->addSql('ALTER TABLE seat DROP CONSTRAINT FK_3D5C366641A67722');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE reservation_item');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE screen');
        $this->addSql('DROP TABLE seat');
    }
}
