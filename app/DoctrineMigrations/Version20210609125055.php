<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609125055 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL('CREATE TABLE IF NOT EXISTS `marca_bandera`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `empresa_id` INT NOT NULL,
            `nombre` VARCHAR(250) NULL,
            `entorno` VARCHAR(1000) NULL,
            PRIMARY KEY (`id`)
        );');
        $this->addSQL('CREATE TABLE IF NOT EXISTS `actividad_servicio`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `combustible_liquido` INT NULL,
            `gnc` INT NULL,
            `otro` INT NULL,
            `lavadero` INT NULL,
            `cambio_aceite` INT NULL,
            `marcaBandera_id` INT NOT NULL,
            `otro_secundario` VARCHAR(500) NULL,
            PRIMARY KEY (`id`)
        );');
        $this->addSQL('CREATE TABLE IF NOT EXISTS `boca_expendio`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `tipo_servicio` VARCHAR(250) NULL,
            `boca_expendio` INT NULL,
            `nombre_producto` VARCHAR(250) NULL,
            `caudal` VARCHAR(250) NULL,
            `observacion` VARCHAR(500) NULL,
            `actividadServicio_id` INT NOT NULL,
            PRIMARY KEY (`id`)
        );');

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL('DROP TABLE `marca_bandera`');
        $this->addSQL('DROP TABLE `actividad_servicio`');
        $this->addSQL('DROP TABLE `boca_expendio`');

    }
}
