<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250421145010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE take_away_booking DROP INDEX UNIQ_4994A17A76ED395, ADD INDEX IDX_4994A17A76ED395 (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE take_away_booking CHANGE user_id user_id INT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE take_away_booking DROP INDEX IDX_4994A17A76ED395, ADD UNIQUE INDEX UNIQ_4994A17A76ED395 (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE take_away_booking CHANGE user_id user_id INT NOT NULL
        SQL);
    }
}
