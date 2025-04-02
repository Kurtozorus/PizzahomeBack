<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402175416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD category_id INT NOT NULL, ADD takeawaybooking_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD CONSTRAINT FK_D43829F712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD CONSTRAINT FK_D43829F743CC6198 FOREIGN KEY (takeawaybooking_id) REFERENCES take_away_booking (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D43829F712469DE2 ON food (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D43829F743CC6198 ON food (takeawaybooking_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP FOREIGN KEY FK_D43829F712469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP FOREIGN KEY FK_D43829F743CC6198
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D43829F712469DE2 ON food
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D43829F743CC6198 ON food
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP category_id, DROP takeawaybooking_id
        SQL);
    }
}
