<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210701144521 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        
        $this->addSQL("CREATE TABLE IF NOT EXISTS `loteo`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(255) DEFAULT NULL,
            `numeroExpediente` VARCHAR(255) DEFAULT NULL,
            `descripcionProyecto` VARCHAR(7500) DEFAULT NULL,
            `tramite_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `urbanizacion`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `calleRuta` VARCHAR(255) DEFAULT NULL,
            `numeroKm` VARCHAR(255) DEFAULT NULL,
            `entreCalles` VARCHAR(255) DEFAULT NULL,
            `superficieTotal` INT(11) DEFAULT NULL,
            `desarrolloEtapa` VARCHAR(500) DEFAULT NULL,
            `riesgoHidrico` INT(11) DEFAULT NULL,
            `loteo_id` INT(11) DEFAULT NULL,
            `empresa_id` INT(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `objeto_subdivision`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `objeto` VARCHAR(255) DEFAULT NULL,
            `tramite_id` INT(11) NOT NULL,
            `urbanizacion_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `dimensionamiento_loteo`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `superficieTotal` VARCHAR(255) DEFAULT NULL,
            `cantidadLotes` INT DEFAULT NULL,
            `superficieTotalLoteada` INT DEFAULT NULL,
            `urbanizacion_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `destino_suelo`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `tipo` VARCHAR(255) DEFAULT NULL,
            `nombre` VARCHAR(255) DEFAULT NULL,
            `superficie` INT(11) DEFAULT NULL,
            `porcentaje` INT(11) DEFAULT NULL,
            `urbanizacion_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("ALTER TABLE `domicilio` CHANGE COLUMN `calle` `calle` VARCHAR(255) NULL DEFAULT NULL;
            ALTER TABLE `domicilio` CHANGE COLUMN `numero` `numero` VARCHAR(255) NULL DEFAULT NULL;
            ALTER TABLE `domicilio` CHANGE COLUMN `piso` `piso` VARCHAR(255) NULL DEFAULT NULL;
            ALTER TABLE `domicilio` CHANGE COLUMN `depto` `depto` VARCHAR(255) NULL DEFAULT NULL;
            ALTER TABLE `domicilio` CHANGE COLUMN `telefono` `telefono` VARCHAR(255) NULL DEFAULT NULL;
            ALTER TABLE `domicilio` CHANGE COLUMN `email` `email` VARCHAR(255) NULL DEFAULT NULL;
        ");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `factibilidad_servicio`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `recoleccionRsu` INT DEFAULT NULL,
            `cloacasRed` INT DEFAULT NULL,
            `gas` INT DEFAULT NULL,
            `energiaElectrica` INT DEFAULT NULL,
            `aguaPotable` INT DEFAULT NULL,
            `transportePublico` INT DEFAULT NULL,
            `otras` VARCHAR(255) DEFAULT NULL,
            `urbanizacion_id` INT(11) NOT NULL,
            PRIMARY KEY (`id`)
        );");
        

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE loteo');
        $this->addSql('DROP TABLE objeto_subdivision');
        $this->addSql('DROP TABLE urbanizacion');
        $this->addSql('DROP TABLE dimensionamiento_loteo');
        $this->addSql('DROP TABLE destino_suelo');
        $this->addSql('DROP TABLE factibilidad_servicio');
    }
}
