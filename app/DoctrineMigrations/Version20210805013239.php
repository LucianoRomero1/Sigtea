<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805013239 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS `ubicacion_feedlot`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `distanciaUrbana` INT DEFAULT NULL,
            `distanciaAsentamiento` INT DEFAULT NULL,
            `distanciaAnimal` INT DEFAULT NULL,
            `distanciaEspejoAgua` INT DEFAULT NULL,
            `distanciaOtroEstablecimiento` INT DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `memoria_descriptiva_feedlot`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `capacidadMaxima` INT DEFAULT NULL,
            `cantidadAnimal` INT DEFAULT NULL,
            `superficieEstablecimiento` INT DEFAULT NULL,
            `superficieAnimal` INT DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `topografia`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `descripcionSitio` VARCHAR(255) DEFAULT NULL,
            `descripcionPendientes` VARCHAR(255) DEFAULT NULL,
            `tipoSuelo` VARCHAR(255) DEFAULT NULL,
            `permeabilidad` VARCHAR(255) DEFAULT NULL,
            `tratamientoSuelo` VARCHAR(255) DEFAULT NULL,
            `abastecimientoAgua` VARCHAR(255) DEFAULT NULL,
            `profundidad` VARCHAR(255) DEFAULT NULL,
            `distanciaBombeo` VARCHAR(255) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `viento`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `direccionPredominante` VARCHAR(500) DEFAULT NULL,
            `recurso_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tratamiento_planta_exterior`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `item` INT DEFAULT NULL,
            `nombre` VARCHAR(255) DEFAULT NULL,
            `numeroRegistro` INT DEFAULT NULL,
            `numeroDestruccion` INT DEFAULT NULL,
            `empresaTransportista` VARCHAR(255) DEFAULT NULL,
            `disposicionFinal` VARCHAR(255) DEFAULT NULL,
            `residuo_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE TABLE ubicacion_feedlot;");
        $this->addSql("DELETE TABLE memoria_descriptiva_feedlot;");
        $this->addSql("DELETE TABLE topografia;");
        $this->addSql("DELETE TABLE viento;");
        $this->addSql("DELETE TABLE tratamiento_planta_exterior;");

    }
}
