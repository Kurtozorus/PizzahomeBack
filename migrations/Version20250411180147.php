<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250411180147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE food_take_away_booking (food_id INT NOT NULL, take_away_booking_id INT NOT NULL, INDEX IDX_C96D993BBA8E87C4 (food_id), INDEX IDX_C96D993BFC6DFCAE (take_away_booking_id), PRIMARY KEY(food_id, take_away_booking_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking ADD CONSTRAINT FK_C96D993BBA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking ADD CONSTRAINT FK_C96D993BFC6DFCAE FOREIGN KEY (take_away_booking_id) REFERENCES take_away_booking (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking DROP FOREIGN KEY FK_C96D993BBA8E87C4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking DROP FOREIGN KEY FK_C96D993BFC6DFCAE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_take_away_booking
        SQL);
    }
}
