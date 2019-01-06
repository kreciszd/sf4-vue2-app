<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190105093010 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brewer (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, INDEX IDX_8C2B4A4BF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE beer (id INT AUTO_INCREMENT NOT NULL, brewer_id INT NOT NULL, type_id INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(100) NOT NULL, size VARCHAR(100) NOT NULL, price NUMERIC(10, 2) NOT NULL, price_per_liter NUMERIC(10, 2) NOT NULL, image_url VARCHAR(255) NOT NULL, abv NUMERIC(3, 1) NOT NULL, style VARCHAR(100) DEFAULT NULL, attributes VARCHAR(100) DEFAULT NULL, on_sale TINYINT(1) NOT NULL, beer_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_58F666ADBCA4F952 (brewer_id), INDEX IDX_58F666ADC54C8C93 (type_id), INDEX IDX_58F666AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brewer ADD CONSTRAINT FK_8C2B4A4BF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADBCA4F952 FOREIGN KEY (brewer_id) REFERENCES brewer (id)');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666AD12469DE2');
        $this->addSql('ALTER TABLE brewer DROP FOREIGN KEY FK_8C2B4A4BF92F3E70');
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADC54C8C93');
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADBCA4F952');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE brewer');
        $this->addSql('DROP TABLE beer');
    }
}
