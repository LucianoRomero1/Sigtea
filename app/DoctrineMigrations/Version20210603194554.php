<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210603194554 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS `mensaje`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `tramite_id` INT NOT NULL,
            `mensaje` VARCHAR(250) NOT NULL,
            `usuario_id` INT NOT NULL,
            `fecha_creacion` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        );");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("DROP TABLE `mensaje`;");

    }
}
