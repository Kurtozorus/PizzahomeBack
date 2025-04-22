<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250418144251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, guest_number SMALLINT NOT NULL, order_date DATE NOT NULL, order_hour DATETIME NOT NULL, guest_allergy VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE booking_user (booking_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9502F4073301C60 (booking_id), INDEX IDX_9502F407A76ED395 (user_id), PRIMARY KEY(booking_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(36) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(64) NOT NULL, description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_D43829F712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE food_take_away_booking (food_id INT NOT NULL, take_away_booking_id INT NOT NULL, INDEX IDX_C96D993BBA8E87C4 (food_id), INDEX IDX_C96D993BFC6DFCAE (take_away_booking_id), PRIMARY KEY(food_id, take_away_booking_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT NOT NULL, food_id INT NOT NULL, public_path VARCHAR(255) NOT NULL, local_path VARCHAR(255) NOT NULL, title VARCHAR(32) NOT NULL, slug VARCHAR(64) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_16DB4F89B1E7706E (restaurant_id), INDEX IDX_16DB4F89BA8E87C4 (food_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(32) NOT NULL, description LONGTEXT NOT NULL, am_opening_time LONGTEXT NOT NULL COMMENT '(DC2Type:array)', pm_opening_time LONGTEXT NOT NULL COMMENT '(DC2Type:array)', max_guest SMALLINT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_EB95123F7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE take_away_booking (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_4994A17A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, first_name VARCHAR(32) NOT NULL, last_name VARCHAR(64) NOT NULL, allergy LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', api_token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', available_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', delivered_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_user ADD CONSTRAINT FK_9502F4073301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_user ADD CONSTRAINT FK_9502F407A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food ADD CONSTRAINT FK_D43829F712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking ADD CONSTRAINT FK_C96D993BBA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking ADD CONSTRAINT FK_C96D993BFC6DFCAE FOREIGN KEY (take_away_booking_id) REFERENCES take_away_booking (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE take_away_booking ADD CONSTRAINT FK_4994A17A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_user DROP FOREIGN KEY FK_9502F4073301C60
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE booking_user DROP FOREIGN KEY FK_9502F407A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food DROP FOREIGN KEY FK_D43829F712469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking DROP FOREIGN KEY FK_C96D993BBA8E87C4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE food_take_away_booking DROP FOREIGN KEY FK_C96D993BFC6DFCAE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89B1E7706E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89BA8E87C4
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F7E3C61F9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE take_away_booking DROP FOREIGN KEY FK_4994A17A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE booking_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE category
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE food_take_away_booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE image
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE picture
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE restaurant
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE take_away_booking
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messenger_messages
        SQL);
    }
}
