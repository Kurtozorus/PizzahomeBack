<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250402172454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE picture ADD food_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_16DB4F89BA8E87C4 ON picture (food_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89BA8E87C4
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_16DB4F89BA8E87C4 ON picture
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE picture DROP food_id
        SQL);
    }
}
