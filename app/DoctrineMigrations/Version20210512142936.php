<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210512142936 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("ALTER TABLE `persona` DROP COLUMN `apellido`;");
        $this->addSQL("ALTER TABLE `persona` DROP COLUMN `nombre`;");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("ALTER TABLE `persona` ADD COLUMN `apellido` VARCHAR 250 NULL;");
        $this->addSQL("ALTER TABLE `persona` Add COLUMN `nombre` VARCHAR 250 NULL;");

    }
}
