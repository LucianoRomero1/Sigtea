<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210923153555 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS `medida_corriente_desecho`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `tipo` VARCHAR(45) DEFAULT NULL,
            `nombre`  VARCHAR(45) DEFAULT NULL,
            `descripcion`  VARCHAR(500) DEFAULT NULL,
            `residuo_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_monitoreo`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(100) DEFAULT NULL,
            `descripcion`  VARCHAR(500) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `monitoreo_residuo`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `descripcion` VARCHAR(500) DEFAULT NULL,
            `tipo_monitoreo_id` INT(11) DEFAULT NULL,
            `residuo_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("DROP TABLE `medida_corriente_desecho`");
        $this->addSQL("DROP TABLE `tipo_monitoreo`");
        $this->addSQL("DROP TABLE `monitoreo_residuo`");
    }
}
