<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210806131212 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("ALTER TABLE `dimensionamiento_planta` ADD COLUMN `superficieSinEdificar` VARCHAR(250) DEFAULT NULL, CHANGE COLUMN `dotacion_personal` `dotacion_personal` VARCHAR(250) DEFAULT NULL");
        $this->addSql("ALTER TABLE `planta` ADD COLUMN `periodoServicio` VARCHAR(250) DEFAULT NULL");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `almacenamiento`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `cantidad` INT DEFAULT NULL,
            `unidad` VARCHAR(255) DEFAULT NULL,
            `periodo` VARCHAR(255) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            `tipo_almacenamiento_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("INSERT INTO `tipo_almacenamiento` (`nombre`) VALUES ('silos')");
        $this->addSQL("INSERT INTO `tipo_almacenamiento` (`nombre`) VALUES ('celdas')");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `barrera_artificial`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `numero` INT DEFAULT NULL,
            `ubicacion` VARCHAR(255) DEFAULT NULL,
            `altura` INT DEFAULT NULL,
            `longitud` INT DEFAULT NULL,
            `material` VARCHAR(255) DEFAULT NULL,
            `tipo` VARCHAR(255) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `barrera_vegetal`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `numero` INT DEFAULT NULL,
            `genero_especie` VARCHAR(255) DEFAULT NULL,
            `fecha_plantacion` DATE DEFAULT NULL,
            `sistema_plantacion` VARCHAR(255) DEFAULT NULL,
            `ubicacion` VARCHAR(255) DEFAULT NULL,
            `numero_arboles` INT DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `proceso_grano`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `etapa` VARCHAR(255) DEFAULT NULL,
            `paso` INT DEFAULT NULL, 
            `operatoria` VARCHAR(255) DEFAULT NULL,
            `observacion` VARCHAR(3000) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `producto_servicio_auxiliar`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `numero` INT DEFAULT NULL, 
            `descripcion` VARCHAR(255) DEFAULT NULL,
            `cantidad` INT DEFAULT NULL,
            `unidad` VARCHAR(3000) DEFAULT NULL,
            `responsable` VARCHAR(3000) DEFAULT NULL,
            `tipo_aplicacion_auxiliar_id` INT(11) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_aplicacion_auxiliar`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("INSERT INTO `tipo_aplicacion_auxiliar` (`nombre`) VALUES ('Manual')");
        $this->addSQL("INSERT INTO `tipo_aplicacion_auxiliar` (`nombre`) VALUES ('Equipamiento fijo')");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `ruido`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(255) DEFAULT NULL,
            `horario` VARCHAR(255) DEFAULT NULL,
            `caracteristica` VARCHAR(255) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            `tipo_ruido_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_ruido`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("INSERT INTO `tipo_ruido` (`nombre`) VALUES ('Aireadores de silos')");
        $this->addSQL("INSERT INTO `tipo_ruido` (`nombre`) VALUES ('Secadoras')");
        $this->addSQL("INSERT INTO `tipo_ruido` (`nombre`) VALUES ('Zaranda')");
        $this->addSQL("INSERT INTO `tipo_ruido` (`nombre`) VALUES ('Otro')");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE `almacenamiento`");
        $this->addSql("DROP TABLE `barrera_artificial`");
        $this->addSql("DROP TABLE `barrera_vegetal`");
        $this->addSql("DROP TABLE `proceso_grano`");
        $this->addSql("DROP TABLE `producto_servicio_auxiliar`");
        $this->addSql("DROP TABLE `tipo_aplicacion_auxiliar`");
        $this->addSql("DROP TABLE `ruido`");
        $this->addSql("DROP TABLE `tipo_ruido`");
    }
}
