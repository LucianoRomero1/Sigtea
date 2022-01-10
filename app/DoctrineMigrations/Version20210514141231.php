<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210514141231 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("ALTER TABLE `planta` CHANGE COLUMN `domicilio_id` `domicilio_id` INT(11) NULL");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("ALTER TABLE `planta` CHANGE COLUMN `domicilio_id` `domicilio_id` INT(11) NOT NULL");

    }
}
