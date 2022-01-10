<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210507174414 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("ALTER TABLE `domicilio`
        CHANGE COLUMN `calle` `calle` VARCHAR(255) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `id`,
        CHANGE COLUMN `numero` `numero` VARCHAR(50) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `calle`,
        CHANGE COLUMN `piso` `piso` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `numero`,
        CHANGE COLUMN `depto` `depto` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `piso`,
        CHANGE COLUMN `telefono` `telefono` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `depto`,
        CHANGE COLUMN `email` `email` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci' AFTER `telefono`,
        CHANGE COLUMN `zonificacion` `zonificacion` TINYINT(3) NULL AFTER `email`,
        CHANGE COLUMN `tipo` `tipo` TINYINT(3) NOT NULL AFTER `zonificacion`,
        CHANGE COLUMN `empresa_id` `empresa_id` INT(11) NOT NULL AFTER `tipo`;");

        $this->addSQL("ALTER TABLE `planta`
        CHANGE COLUMN `nombre` `nombre` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci' AFTER `id`,
        CHANGE COLUMN `fecha_inicio_actividades` `fecha_inicio_actividades` DATE NULL AFTER `nombre`,
        CHANGE COLUMN `fuera_provincia` `fuera_provincia` TINYINT(4) NULL AFTER `fecha_inicio_actividades`,
        CHANGE COLUMN `superficie_deposito` `superficie_deposito` DOUBLE(22,0) NULL AFTER `fuera_provincia`,
        CHANGE COLUMN `superficie_total` `superficie_total` DOUBLE(22,0) NULL AFTER `superficie_deposito`,
        CHANGE COLUMN `superficie_cubierta` `superficie_cubierta` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci' AFTER `superficie_total`,
        CHANGE COLUMN `potencia_instalada` `potencia_instalada` DOUBLE(22,0)  NULL AFTER `superficie_cubierta`,
        CHANGE COLUMN `dotacion_personal` `dotacion_personal` VARCHAR(100)  NULL COLLATE 'latin1_swedish_ci' AFTER `potencia_instalada`,
        CHANGE COLUMN `empresa_id` `empresa_id` INT(11) NOT NULL AFTER `dotacion_personal`, 
        CHANGE COLUMN `domicilio_id` `domicilio_id` INT(11) NOT NULL AFTER `empresa_id`;
;");

    }

    public function down(Schema $schema) : void
    {      
        $this->addSQL("ALTER TABLE `domicilio`
        CHANGE COLUMN `calle` `calle` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci' AFTER `id`,
        CHANGE COLUMN `numero` `numero` VARCHAR(50) NULL COLLATE 'latin1_swedish_ci' AFTER `calle`,
        CHANGE COLUMN `piso` `piso` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci' AFTER `numero`,
        CHANGE COLUMN `depto` `depto` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci' AFTER `piso`,
        CHANGE COLUMN `telefono` `telefono` VARCHAR(20) NULL COLLATE 'latin1_swedish_ci' AFTER `depto`,
        CHANGE COLUMN `email` `email` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci' AFTER `telefono`,
        CHANGE COLUMN `zonificacion` `zonificacion` TINYINT(3) NULL AFTER `email`,
        CHANGE COLUMN `tipo` `tipo` TINYINT(3) NULL AFTER `zonificacion`,
        CHANGE COLUMN `empresa_id` `empresa_id` INT(11) NULL AFTER `tipo`;");

        $this->addSQL("ALTER TABLE `planta`
        CHANGE COLUMN `nombre` `nombre` VARCHAR(255) NULL COLLATE 'latin1_swedish_ci' AFTER `id`,
        CHANGE COLUMN `fecha_inicio_actividades` `fecha_inicio_actividades` DATE NULL AFTER `nombre`,
        CHANGE COLUMN `fuera_provincia` `fuera_provincia` TINYINT(4) NULL AFTER `fecha_inicio_actividades`,
        CHANGE COLUMN `superficie_deposito` `superficie_deposito` DOUBLE(22,0) NULL AFTER `fuera_provincia`,
        CHANGE COLUMN `superficie_total` `superficie_total` DOUBLE(22,0) NULL AFTER `superficie_deposito`,
        CHANGE COLUMN `superficie_cubierta` `superficie_cubierta` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci' AFTER `superficie_total`,
        CHANGE COLUMN `potencia_instalada` `potencia_instalada` DOUBLE(22,0) NULL AFTER `superficie_cubierta`,
        CHANGE COLUMN `dotacion_personal` `dotacion_personal` VARCHAR(100) NULL COLLATE 'latin1_swedish_ci' AFTER `potencia_instalada`,
        CHANGE COLUMN `empresa_id` `empresa_id` INT(11) NULL AFTER `dotacion_personal`,
        CHANGE COLUMN `domicilio_id` `domicilio_id` INT(11) NULL AFTER `empresa_id`;
;");
    }
}
