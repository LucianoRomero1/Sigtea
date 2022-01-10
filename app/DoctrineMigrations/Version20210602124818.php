<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602124818 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS `estado` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `descripcion` VARCHAR(100) NOT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSQL("ALTER TABLE `tramite` CHANGE COLUMN `estado` `estado_id` INT NOT NULL");
        $this->addSQL("ALTER TABLE `listaTramites` ADD COLUMN `url` VARCHAR(100) NOT NULL");
        $this->addSQL("UPDATE `listaTramites` SET `url`='formularioUrbanizacion',`descripcion`='Loteo con fines de Urbanización: Formularios de presentación' WHERE  `id`=1;
            UPDATE `listaTramites` SET `url`='formularioUrbanizacionEstudioImpactoAmbiental', `descripcion`='Loteo con fines de Urbanización: Estudio de Impacto Ambiental' WHERE  `id`=2;
            UPDATE `listaTramites` SET `url`='formularioIndustriasEstudioImpactoAmbiental', `descripcion`='Industrias y otras actividades sin normativa específica: Estudio de Impacto Ambiental' WHERE  `id`=3;
            UPDATE `listaTramites` SET `url`='formularioIndustrias', `descripcion`='Industrias y otras actividades sin normativa específica: Formulario de Presentación' WHERE  `id`=4;
            UPDATE `listaTramites` SET `url`='formularioIndustriasInformeAmbientalCumplimiento', `descripcion`='Industrias y otras actividades sin normativa específica: Informe Ambiental de Cumplimiento' WHERE  `id`=5;
            UPDATE `listaTramites` SET `url`='formularioAcopiosGranos', `descripcion`='Acopios de granos: Presentación de Declaración Jurada, Estudio de Impacto' WHERE  `id`=6;
            UPDATE `listaTramites` SET `url`='formularioMinistrerioAmbiente', `descripcion`='Ministerio de Ambiente y Cambio ClimáticoSubsecretaría de Evaluación AmbientalAmbiental e Informe Ambiental de Cumplimiento' WHERE  `id`=7;
            UPDATE `listaTramites` SET `url`='formularioExpendioCombustible', `descripcion`='Combustibles: Formulario de Presentación e Informe Ambiental de Cumplimiento (I.A.C) para establecimientos en funcionamiento' WHERE  `id`=8;
            UPDATE `listaTramites` SET `url`='formularioFeedInformeAmbiental', `descripcion`='Feed Lots: Presentación de Declaración Jurada e Informe Ambiental de Cumplimiento (I.A.C) para establecimientos en funcionamiento' WHERE  `id`=9;
            UPDATE `listaTramites` SET `url`='formularioEstudioImpactoAmbiental', `descripcion`='Feed Lots: Presentación de Declaración Jurada y Estudio de ImpactoAmbiental (Es.I.A) para nuevos establecimientos' WHERE  `id`=10;
            UPDATE `listaTramites` SET `url`='formularioRenovacionCertificado', `descripcion`='Renovación del certificado de aptitud ambiental (C.A.A) para empresas en funcionamiento' WHERE  `id`=11;
            UPDATE `listaTramites` SET `url`='formularioCertificadoEmpresasNuevas', `descripcion`='Solicitud de certificado de aptitud ambiental para empresas nuevas (C.A.A)' WHERE  `id`=12;
            UPDATE `listaTramites` SET `url`='formularioCertificadoEmpresasNoRegistradas', `descripcion`='Solicitud de certificado de aptitud ambiental para empresas no registradas' WHERE  `id`=13;
            UPDATE `listaTramites` SET `url`='formularioCambioTitularidad', `descripcion`='Cambio de Titularidad y Actualización de Datos de las empresas' WHERE  `id`=14;
        ");
      
    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("DROP TABLE `estado`;");
    }
}
