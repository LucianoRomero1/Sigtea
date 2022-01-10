<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210909190924 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS sitio_contaminado(
            `id` INT NOT NULL AUTO_INCREMENT,
            `ubicacion_georeferencial` VARCHAR(250) DEFAULT NULL,
            `descripcion` VARCHAR(250) DEFAULT NULL ,
            `parametros_interes` VARCHAR(50) DEFAULT NULL ,
            `plan_monitoreo` VARCHAR(50) DEFAULT NULL ,
            `plan_remediacion` VARCHAR(50) DEFAULT NULL ,
            `planta_id` INT NOT NULL ,
            PRIMARY KEY (`id`)
        )");
        $this->addSQL("ALTER TABLE `riesgo_presunto` ADD COLUMN `proceso` VARCHAR(250) NOT NULL;");
        $this->addSQL("ALTER TABLE `riesgo_presunto`
        CHANGE COLUMN `fuentes_moviles` `fuentes_moviles` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `aparato_sometido` `aparato_sometido` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `sustancia_quimica` `sustancia_quimica` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `explosion` `explosion` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `incendio` `incendio` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `otro` `otro` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `acustico` `acustico` BIT NULL DEFAULT NULL ,
        CHANGE COLUMN `presion` `presion` BIT NULL DEFAULT NULL;
        ");
        $this->addSql("ALTER TABLE `sitio_contaminado`
        CHANGE COLUMN `parametros_interes` `parametros_interes` VARCHAR(250) NULL DEFAULT NULL  ,
        CHANGE COLUMN `plan_monitoreo` `plan_monitoreo` VARCHAR(250) NULL DEFAULT NULL ,
        CHANGE COLUMN `plan_remediacion` `plan_remediacion` VARCHAR(250) NULL DEFAULT NULL ;
        ");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE TABLE sitio_contaminado;");

    }
}
