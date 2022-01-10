<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210908184356 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE `riesgo_presunto` ADD COLUMN `acustico` BINARY(50) NOT NULL, ADD COLUMN `presion` BINARY(50) NOT NULL;");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE `riesgo_presunto` DROP COLUMN `acustico`, DROP COLUMN `presion`;");

    }
}
