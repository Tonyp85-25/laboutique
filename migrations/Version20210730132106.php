<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210730132106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        //    $table= $schema->getTable('order');
        //    $table->addColumn('reference',[
        //        'default'=>'noreference',
        //        'notnull'=>true
        //    ]);
        $ref='noref';
        $this->addSql('ALTER TABLE "order" ADD reference VARCHAR(255)');
        $this->addSql('UPDATE "order" SET reference = :ref WHERE reference IS NULL',[$ref]);
        $this->addSql('ALTER TABLE "order" ALTER COLUMN "reference" SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "order" DROP reference');
    }
}
