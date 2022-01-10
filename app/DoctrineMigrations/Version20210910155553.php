<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210910155553 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_operacion`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `operacion` VARCHAR(255) DEFAULT NULL,
            `detalle_operacion`  VARCHAR(500) DEFAULT NULL,
            `numero_operacion` INT DEFAULT NULL,
            `tratamiento_planta_propia_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

        $this->addSQL("CREATE TABLE IF NOT EXISTS `tratamiento_planta_propia`(
        `id` INT NOT NULL AUTO_INCREMENT,
        `item` INT DEFAULT NULL,
        `tratamiento_incompleto` TINYINT(3) DEFAULT NULL,
        `residuo_id` INT(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
        );");

        $this->addSQL("CREATE TABLE IF NOT EXISTS `gas`(
        `id` INT NOT NULL AUTO_INCREMENT,
        `nombre` VARCHAR(255) DEFAULT NULL,
        `consumo`  FLOAT DEFAULT NULL,
        `tipo`  VARCHAR(255) DEFAULT NULL,
        `recurso_id` INT(11) DEFAULT NULL,
        PRIMARY KEY (`id`)
        );");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE `tipo_operacion`");
        $this->addSql("DROP TABLE `tratamiento_planta_propia`");
        $this->addSql("DROP TABLE `gas`");
    }
}
