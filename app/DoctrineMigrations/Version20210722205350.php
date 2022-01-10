<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722205350 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("ALTER TABLE `producto` CHANGE COLUMN `clasificacion` `clasificacion` VARCHAR(250) NULL,
        CHANGE COLUMN `especificacion` `especificacion` VARCHAR(250) NULL;");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
