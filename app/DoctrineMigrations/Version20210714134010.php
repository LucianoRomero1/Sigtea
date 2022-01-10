<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210714134010 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("CREATE TABLE IF NOT EXISTS listado_tipo_residuo (`id` int(11) NOT NULL AUTO_INCREMENT,`clase` varchar(5) NOT NULL,`descripcion` varchar(100) NOT NULL,`tipo` varchar(50) NOT NULL, PRIMARY KEY (`id`))");
        $this->addSQL("
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y02','DESECHOS RESULTANTES DE LA PRODUCCIÓN Y PREPARACIÓN DE PRODUCTOS FARMACÉUTICOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y03','DESECHOS DE MEDICAMENTOS Y PRODUCTOS FARMACÉUTICOS PARA LA SALUD HUMANA Y ANIMAL','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y04','DESECHOS RESULTANTES DE LA PRODUCCIÓN,LA PREPARACIÓN Y UTILIZACIÓN DE BIOCIDAS Y PRODUCTOS FITOSANITARIOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y05','DESECHOS RESULTANTES DE LA FABRICACIÓN,PREPARACIÓN Y UTILIZACIÓN DE PRODUCTOS QUÍMICOS PARA KA PRESERVACIÓN DE LA MADERA','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y06','DESECHOS RESULTANTES DE LA FABRICACIÓN,PREPARACIÓN Y UTILIZACIÓN DE DISOLVENTES ORGÁNICOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y07','DESECHOS QUE CONTENGAN CIANUROS,RESULTANTES DEL TRATAMIENTO TÉRMICO Y LAS OPERACIONES DE TEMPLE','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y08','DESECHOS DE ACEITES MINERALES NO APTOS PARA EL USO A QUE ESTABAN DESTINADOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y09','MEZCLAS Y EMULSIONES DE DESECHO DE ACEITE Y AGUA O DE HIDROCARBUROS Y AGUA','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y10','SUSTANCIAS Y ARTÍCULOS DE DESECHO QUE CONTENGAN O ESTÉN CONTAMINADOS POR BIFENILOS POLICLORADOS (PCB) TRIFENILOS POLICLORADOS (PCT) O BIFENILOS POLIBROMADOS (PBB)','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y11','RESIDUOS ALQUITRANADOS RESULTANTES DE LA REFINACIÓN,DESTILACIÓN O CUALQUIER OTRO TRATAMIENTO PIROLÍTICO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y12','DESECHOS RESULTANTES DE LA PRODUCCIÓN,PREPARACIÓN Y UTILIZACIÓN DE TINTAS,COLORANTES,PIGMENTOS,PINTURAS,LACAS O BARNICES','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y13','DESECHOS RESULTANTES DE LA PRODUCCIÓN,PREPARACIÓN Y UTILIZACIÓN DE RESINAS,LATÉX,PLASTIFICANTES O COLAS Y ADHESIVOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y14','SUSTANCIAS QUÍMICAS DE DESECHO,NO IDENTIFICADAS O NUEVAS,RESULTANTES DE LA INVESTIGACIÓN Y EL DESARROLLO O DE LAS ACTIVIDADES DE ENSEÑANZA Y CUYOS EFECTOS EN EL SER HUMANO O EL MEDIO AMBIENTE NO SE CONOZCAN','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y15 ','DESECHOS DE CARÁCTER EXPLOSIVO QUE NO ESTÉN SOMETIDOS A UNA LEGISLACIÓN DIFERENTE','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y16','DESECHOS RESULTANTES DE LA PRODUCCIÓN,PREPARACIÓN Y UTILIZACIÓN DE PRODUCTOS QUÍMICOS Y MATERIALES PARA FINES FOTOGRÁFICOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y17','DESECHOS RESULTANTES DEL TRATAMIENTO DE SUPERFICIES DE METALES Y PLÁSTICOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y18','RESIDUOS RESULTANTES DE LAS OPERACIONES DE ELIMINACIÓN DE DESECHOS INDUSTRIALES','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y19','METALES CARBONILOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y20','BERILIO,COMPUESTO DE BERILIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y21','COMPUESTOS DE CROMO HEXAVALENTE','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y22','COMPUETOS DE COBRE','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y23','COMPUESTOS DE ZINC','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y24','ARSÉNICO,COMPUESTOS DE ARSÉNICO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y25','SELENIO,COMPUESTOS DE SELENIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y26','CADMIO,COMPUESTOS DE CADMIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y27','ANTIMONIO,COMPUESTOS DE ANTIMONIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y28','TELURIO,COMPUESTOS DE TELURIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y29','MERCURIO,COMPUESTOS DE MERCURIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y30','TALIO,COMPUESTOS DE TALIO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y31','PLOMO,COMPUESTOS DE PLOMO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y32','COMPUESTOS INORGÁNICOS DE FLÚOR,CON EXCLUSIÓN DE FLUORURO CÁLCICO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y33','CIANUROS INORGÁNICOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y34','SOLUCIONES ÁCIDAS O ÁCIDOS EN FORMA SÓLIDA','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y35','SOLUCIONES BÁSICAS O BASES EN FORMA SÓLIDA','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y36','ASBESTOS (POLVO Y FIBRAS)','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y37','COMPUESTOS ORGÁNICOS DE FÓSFORO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y38','CIANUROS ORGÁNICOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y39','FENOLES,COMPUESTOS FENÓLICOS,CON INCLUSIÓN DE CLOROFENOLES','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y40','ETERES','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y41','SOLVENTES ORGÁNICOS HALOGENADOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y42','DISOLVENTES ORGÁNICOS,CON EXCLUSIÓN DE DISOLVENTES HALOGENADOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y43','CUALQUIER SUSTANCIA DEL GRUPO DE LOS DIBENZOFURANOS POLICLORADOS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y44','CUALQUIER SUSTANCIA DEL GRUPO DE LOS DIBENZOPARADIOXINAS POLICLORADAS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y45','COMPUESTOS ORGANOHALOGENADOS,QUE NO SEAN LAS SUSTANCIAS MENCIONADAS','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP01','JABONES,MATERIAS GRASAS,CERAS DE ORIGEN ANIMAL O VEGETAL','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP02','ACEITES VEGETALES','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP03','CEREALES Y OLEAGINOSAS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP04','SUSTANCIAS ORGÁNICAS NO HALOGENADAS NO EMPLEADAS COMO DISOLVENTES','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP05','DESECHOS DE CAUCHO','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP06','SUSTANCIAS INORGÁNICAS QUE NO CONTENGAN METALES PESADOS O SUS COMPUESTOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP07','ESCORIAS Y/O CENIZAS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP08','PARTÍCULAS O POLVOS METÁLICOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP09','CHATARRA DE METAL LIMPIA, NO CONTAMINADA','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP10','TIERRA  ARCILLAS O ARENAS INCLUYENDO LODOS DE DRAGADO','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP11','SALES DE TEMPLE NO CIANURADAS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP12','LÍQUIDOS O LODOS QUE CONTENGAN METALES O COMPUESTOS METÁLICOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP13','RESIDUOS DE TRATAMIENTO DE DESCONTAMINACIÓN (POLVOS DE CÁMARAS DE FILTROS DE BOLSAS,ETC) EXCEPTO LOS MENCIONADOS EN LOS PUNTOS 15,16 Y 19','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP14','CATALIZADORES USADOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP15','LODOS DE LAVADO DE GASES','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP16','LODOS DE INSTALACIONES DE PURIFICACIÓN DE AGUA','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP17','CARBÓN ACTIVADO UTILIZADO PARA EL TRATAMIENTO DE PURIFICACIÓN DE AGUAS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP18','RESIDUOS DE DESCARBONATACIÓN','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP19','RESIDUOS DE COLUMNAS DE INTERCAMBIO IÓNICO','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP20','LODOS DE DEPURACIÓN NO TRATADOS O NO UTILIZABLES EN LA AGRICULTURA','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP21','RESIDUOS DE LA LIMPIEZA DE CISTERNAS Y/O EQUIPOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP22','EQUIPOS CONTAMINADOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP23','RECIPIENTES CONTAMINADOS (ENVASES, BOMBONAS DE GAS, ETC) QUE HAYAN CONTENIDO UNO O VARIOS DE LOS CONSTITUYENTES MENCIONADOS EN ESTE ANEXO','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP24','PINTURAS DE LÁTEX O CON BASE DE AGUA,TINTAS Y BARNICES ENDURECIDOS QUE NO CONTENGAN DISOLVENTES ORGÁNICOS,METALES PESADOS NI BIOCIDAS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP25','DESECHOS DE CERÁMICA','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP26','DESECHOS DE VIDRIO','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP27','MATERIALES PLÁSTICOS','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP28','DESECHOS DE CORCHO Y DE MADERA','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP29','RESINAS CURADAS O PRODUCTOS DE CONDENSACIÓN','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP30','DESECHOS DE TEXTILES','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('Y48','MATERIALES Y/O ELEMENTOS DIVERSOS CONTAMINADOS CON ALGUNO DE LOS RESIDUOS PELIGROSOS IDENTIFICADOS EN EL ANEXO I DEL DECRETO N° 1844/02 Y QUE PRESENTEN ALGUNAS DE LAS CARACTERÍSTICAS DE PELIGROSIDAD ENUMERADAS EN EL  ANEXO II DEL MENCIONADO REGLAMENTO','PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP31','DESECHOS DE MATERIAL CELULÓSICO (PAPEL Y/O CARTÓN)','NO PELIGROSOS');
        INSERT INTO `listado_tipo_residuo` (`clase`, `descripcion`, `tipo`) VALUES ('NP32','RESIDUOS DE PRODUCTOS INOCULANTES LIQUIDOS QUE NO CONTENGAN CARACTERÍSTICAS DE PELIGROSIDAD','NO PELIGROSOS');
        ");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL('DROP TABLE listado_tipo_residuo');;

    }
}
