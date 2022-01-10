<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429192424 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('1', 'Loteo con fines de Urbanización: Formularios de presentación');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('2', 'Loteo con fines de Urbanización: Estudio de Impacto Ambiental');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('3', 'Industrias y otras actividades sin normativa específica: Estudio de Impacto Ambiental.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('4', 'Industrias y otras actividades sin normativa específica: Formulario de Presentación.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('5', 'Industrias y otras actividades sin normativa específica: Informe Ambiental de Cumplimiento');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('6', 'Acopios de granos: Presentación de Declaración Jurada, Estudio de Impacto');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('7', 'Ministerio de Ambiente y Cambio ClimáticoSubsecretaría de Evaluación AmbientalAmbiental e Informe Ambiental de Cumplimiento.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('8', 'Combustibles: Formulario de Presentación e Informe Ambiental de Cumplimiento (I.A.C) para establecimientos en funcionamiento.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('9', 'Feed Lots: Presentación de Declaración Jurada e Informe Ambiental de Cumplimiento (I.A.C) para establecimientos en funcionamiento.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('10', 'Feed Lots: Presentación de Declaración Jurada y Estudio de ImpactoAmbiental (Es.I.A) para nuevos establecimientos.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('11', 'Renovación del certificado de aptitud ambiental (C.A.A) para empresas en funcionamiento.');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('12', 'Solicitud de certificado de aptitud ambiental para empresas nuevas (C.A.A).');
            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('13', 'Solicitud de certificado de aptitud ambiental para empresas no registradas.');            INSERT INTO `listaTramites` (`id`, `descripcion`) VALUES ('14', 'Cambio de Titularidad y Actualización de Datos de las empresas.');
        ");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("TRUNCATE `listaTramites`");
    }
}
