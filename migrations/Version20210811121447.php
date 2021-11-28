<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210811121447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $isBest ='FALSE';
        $this->addSql('ALTER TABLE product ADD is_best BOOLEAN');
        $this->addSql('UPDATE product SET is_best = :isBest WHERE is_best IS NULL',[$isBest]);
        $this->addSql('ALTER TABLE product ALTER COLUMN is_best SET NOT NULL');
        
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE product DROP is_best');
    }
}
