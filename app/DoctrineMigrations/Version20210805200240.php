<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210805200240 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `almacenamiento_tanque` CHANGE COLUMN `presion` `presion` VARCHAR(50) NULL');
        $this->addSql('ALTER TABLE `almacenamiento_tanque` CHANGE COLUMN `sustancia` `sustancia` VARCHAR(50) NULL');
        $this->addSql('ALTER TABLE `agua` CHANGE COLUMN `ubicacionPlano` `ubicacionPlano` VARCHAR(50) NULL');
        $this->addSql('ALTER TABLE `agua` CHANGE COLUMN `nombre` `nombre` VARCHAR(50) NULL');
        $this->addSql('ALTER TABLE `domicilio` ADD COLUMN `titular_inmueble` VARCHAR(100) NULL');
        $this->addSql('ALTER TABLE `impacto` ADD COLUMN `caudal` VARCHAR(255) NULL DEFAULT NULL, ADD COLUMN `cuerpo_receptor` VARCHAR(255) NULL DEFAULT NULL, ADD COLUMN `prevencion` VARCHAR(255) NULL DEFAULT NULL , ADD COLUMN `consecuencia` VARCHAR(255) NULL DEFAULT NULL; ');
        $this->addSql('ALTER TABLE `efluente` CHANGE COLUMN `unidad` `unidad` VARCHAR(250) NULL, CHANGE COLUMN `componente_relevante` `componente_relevante` VARCHAR(250) NULL,CHANGE COLUMN `periodo_tiempo` `periodo_tiempo` VARCHAR(250) NULL, CHANGE COLUMN `gestion` `gestion` VARCHAR(250) NULL, CHANGE COLUMN `proceso_generador` `proceso_generador` VARCHAR(250) NULL;');
        $this->addSql('ALTER TABLE `residuo` CHANGE COLUMN `proceso_generador` `proceso_generador` VARCHAR(250) NULL,CHANGE COLUMN `unidad` `unidad` VARCHAR(250) NULL , CHANGE COLUMN `periodo_tiempo` `periodo_tiempo` VARCHAR(250) NULL, CHANGE COLUMN `gestion` `gestion` VARCHAR(250) NULL,CHANGE COLUMN `receptor` `receptor` VARCHAR(250) NULL;');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `almacenamiento_tanque` CHANGE COLUMN `presion` `presion` VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE `almacenamiento_tanque` CHANGE COLUMN `sustancia` `sustancia` VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE `agua` CHANGE COLUMN `ubicacionPlano` `ubicacionPlano` VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE `agua` CHANGE COLUMN `nombre` `nombre` VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE `domicilio` DROP COLUMN `titular_inmueble`');
        $this->addSql('ALTER TABLE `impacto` DROP COLUMN `caudal`, DROP COLUMN `cuerpo_receptor`, DROP COLUMN `prevencion`, DROP COLUMN `consecuencia`');

    }
}
