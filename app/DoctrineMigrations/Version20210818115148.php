<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210818115148 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS `sustancia_tanque`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `sustancia` VARCHAR(255) DEFAULT NULL,
            `capacidad`  VARCHAR(255) DEFAULT NULL,
            `estado_fisico`  VARCHAR(255) DEFAULT NULL,
            `presurizado` VARCHAR(255) DEFAULT NULL,
            `peligrosidad` VARCHAR(255) DEFAULT NULL,
            `norma_seguridad` VARCHAR(255) DEFAULT NULL,
            `nro_norma` VARCHAR(255) DEFAULT NULL,
            `tanque_id` INT(11) DEFAULT NULL,
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

        $this->addSQL("CREATE TABLE IF NOT EXISTS `otra_energia`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `tipo` VARCHAR(255) DEFAULT NULL,
            `nombre`  VARCHAR(255) DEFAULT NULL,
            `consumo`  VARCHAR(255) DEFAULT NULL,
            `recurso_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

        $this->addSQL("CREATE TABLE IF NOT EXISTS `plano`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `descripcion` VARCHAR(3000) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

        $this->addSQL("CREATE TABLE IF NOT EXISTS `suelo`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `descripcion_uso` VARCHAR(255) DEFAULT NULL,
            `sitio_extraccion` VARCHAR(255) DEFAULT NULL,
            `latitud` VARCHAR(255) DEFAULT NULL,
            `longitud` VARCHAR(255) DEFAULT NULL,
            `origen_gestion` VARCHAR(255) DEFAULT NULL,
            `cantidad_tiempo`  FLOAT DEFAULT NULL,
            `autorizacion_ministerio`  TINYINT(3) DEFAULT NULL,
            `recurso_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

        $this->addSQL("CREATE TABLE IF NOT EXISTS `proceso`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `descripcion` VARCHAR(3000) DEFAULT NULL,
            `tipo`  TINYINT(3) DEFAULT NULL,
            `planta_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

        

        $this->addSql('ALTER TABLE entidad_has_repositorio ADD storage_id INT(11) DEFAULT NULL');
        $this->addSql('ALTER TABLE residuo ADD nro_generador INT(11) DEFAULT NULL');
        $this->addSql('ALTER TABLE agua ADD tipo_agua_id INT(11) DEFAULT NULL');
        $this->addSQL('INSERT INTO `tipo_efluente` (`tipo`) VALUES ("Efluentes Liquidos Industriales");');
        $this->addSQL('INSERT INTO `tipo_efluente` (`tipo`) VALUES ("Efluentes Sanitarios");');
        $this->addSQL('INSERT INTO `tipo_emision` (`tipo`) VALUES ("Puntuales");');
        $this->addSQL('INSERT INTO `tipo_emision` (`tipo`) VALUES ("Difusas");');
        $this->addSQL('INSERT INTO `tipo_agua` (`nombre`) VALUES ("Agua Subterranea");');
        $this->addSQL('INSERT INTO `tipo_agua` (`nombre`) VALUES ("Agua Superficial ");');
        $this->addSQL('INSERT INTO `tipo_agua` (`nombre`) VALUES ("Agua de Red Publica");');


    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE `sustancia_tanque`");
        $this->addSql("DROP TABLE `gas`");
        $this->addSql("DROP TABLE `otra_energia`");
        $this->addSql("DROP TABLE `plano`");
        $this->addSql("DROP TABLE `suelo`");
        $this->addSql("DROP TABLE `proceso`");
    }
}
