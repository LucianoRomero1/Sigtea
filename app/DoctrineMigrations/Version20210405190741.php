<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Creacion de tabla Persona
 */
final class Version20210405190741 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creacion de estructura da la Base de datos';
    }

    public function up(Schema $schema) : void
    {
        // $this->addSql("CREATE DATABASE IF NOT EXISTS `mma_evaluacionambiental`");
        $this->addSql("CREATE TABLE IF NOT EXISTS `actividad` (
          `id` int(11) NOT NULL,
          `cuacm` int(11) NOT NULL,
          `nombreActividad` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
          `estandar` int(11) DEFAULT NULL,
          `grupo_id` int(11) DEFAULT NULL
        )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `departamento` (
          `id` int(11) NOT NULL,
          `provincia_id` int(11) NOT NULL,
          `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL
        )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `dimensionamiento_planta` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `superficie_total` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `superficie_cubierta` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `superficie_instalada` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `dotacion_personal` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `domicilio` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `calle` varchar(255) DEFAULT NULL,
            `numero` varchar(50) DEFAULT NULL,
            `piso` varchar(20) DEFAULT NULL,
            `depto` varchar(20) DEFAULT NULL,
            `telefono` varchar(20) DEFAULT NULL,
            `email` varchar(100) DEFAULT NULL,
            `zonificacion` tinyint(3) DEFAULT NULL,
            `tipo` tinyint(3) DEFAULT NULL,
            `empresa_id` int(11) NOT NULL,
            `provincia_id` int(11) NOT NULL,
            `localidad_id` int(11) NOT NULL,
            `departamento_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `efluente` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `categoria` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tipo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `proceso_generador` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `componente_relevante` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `volumen` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `periodo_tiempo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `gestion` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `descarga` tinyint(4) DEFAULT NULL,
            `receptor` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `planta_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `emision_gaseosa` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `categoria` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tipo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `emision` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `proceso_generador` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tratamiento` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `componente_relevante` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `planta_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `empresa` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `fechaInicioActividad` date NOT NULL,
            `tipoPersona` int(11) NOT NULL,
            `deposito` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `persona_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `empresaHasActividad` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `tipo` tinyint(4) DEFAULT NULL,
            `empresa_id` int(11) NOT NULL,
            `actividad` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `empresaHasRepresentante` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `empresa_id` int(11) NOT NULL,
            `representante_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `formacion_personal` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `cantidad_obrero` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `capacitacion_obrero` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `cantidad_tecnico` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `capacitacion_tecnico` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `cantidad_profesional` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `capacitacion_profesional` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `horario_trabajo` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `grupo` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `inmueble_anexo` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `domicilio` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `actividad_desarrollada` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `partidaInmobiliaria_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `insumo` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado_fisico` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `produccion` int(11) NOT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `almacenamiento` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `listaTramites` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `descripcion` varchar(150) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `localidad` ( 
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `departamento_id` int(11) NOT NULL,
            `codigo_postal` varchar(7) COLLATE utf8_unicode_ci NOT NULL,
            `nombre` varchar(255) COLLATE utf8_unicode_ci NOT NULL, 
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `materia_prima` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado_fisico` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `produccion` int(11) NOT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `almacenamiento` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `migration_versions` (
            `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`version`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `partida_inmobiliaria` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `numero` int(10) DEFAULT NULL,
            `latitud` varchar(100) DEFAULT NULL,
            `longitud` varchar(100) DEFAULT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `perito` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `profesion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `firma` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `persona_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `persona` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `apellido` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `razonSocial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `cuit` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `planta` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) DEFAULT NULL,
            `fecha_inicio_actividades` date DEFAULT NULL,
            `fuera_provincia` tinyint(4) DEFAULT NULL,
            `superficie_deposito` double DEFAULT NULL,
            `superficie_total` double DEFAULT NULL,
            `superficie_cubierta` varchar(100) DEFAULT NULL,
            `potencia_instalada` double DEFAULT NULL,
            `dotacion_personal` varchar(100) DEFAULT NULL,
            `empresa_id` int(11) NULL DEFAULT NULL,
            `domicilio_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `producto` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado_fisico` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `produccion` int(11) NOT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `almacenamiento` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `clasificacion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `especificacion` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `comercio_exterior` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `provincia` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `representante` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `cargo` varchar(50) DEFAULT NULL,
            `tipo` tinyint(2) DEFAULT NULL,
            `firma` varchar(50) DEFAULT NULL,
            `persona_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `residuo` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `categoria` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tipo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `proceso_generador` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `componente_relevante` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `volumen` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `periodo_tiempo` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `gestion` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `receptor` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `planta_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `riesgo_presunto` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `fuentes_moviles` binary(50) NOT NULL,
            `aparato_sometido` binary(50) NOT NULL,
            `sustancia_quimica` binary(50) NOT NULL,
            `explosion` binary(50) NOT NULL,
            `incendio` binary(50) NOT NULL,
            `otro` binary(50) NOT NULL,
            `observaciones` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `servicio` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `energia_electrica` tinyint(4) NOT NULL,
            `cloacas` tinyint(4) NOT NULL,
            `agua_red` tinyint(4) NOT NULL,
            `gas_natural` tinyint(4) NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `subproducto` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado_fisico` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `produccion` int(11) NOT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `almacenamiento` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `sustancia_auxiliar` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado_fisico` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
            `produccion` int(11) NOT NULL,
            `unidad` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `almacenamiento` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `tipo` int(11) DEFAULT NULL,
            `sustancia_auxiliarcol` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `planta_id` int(11) NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `sustancia_riesgosa` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `cantidad` float NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `tanque` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `fecha_creacion` date NOT NULL,
            `fecha_modificacion` date NOT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSql("CREATE TABLE IF NOT EXISTS `tramite` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `fecha_creacion` date NOT NULL,
            `fecha_modificacion` date NULL DEFAULT NULL,
            `perito_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`id`)
          )");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `resumen_ejecutivo` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `nombre` VARCHAR(255) NULL DEFAULT NULL,
          `descripcion` VARCHAR(7500) NULL DEFAULT NULL,
          `nro_expediente` VARCHAR(45) NULL DEFAULT NULL,
          `empresa_id` INT NOT NULL,
          PRIMARY KEY (`id`),
          INDEX `empresa_id` (`empresa_id`),
          CONSTRAINT `FK__empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `caracterizacion_entorno` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `descripcion_inmediata` VARCHAR(3000) NULL DEFAULT NULL,
          `via_acceso` VARCHAR(2400) NULL DEFAULT NULL,
          `situacion_ambiental` VARCHAR(2000) NULL DEFAULT NULL,
          `planta_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `planta_id` (`planta_id`),
          CONSTRAINT `FK_caracterizacion_planta` FOREIGN KEY (`planta_id`) REFERENCES `planta` (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `proyecto` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `definicion` VARCHAR(1800) NULL DEFAULT NULL,
          `cierre` VARCHAR(2600) NULL DEFAULT NULL,
          `produccionAnual` VARCHAR(1800) NULL DEFAULT NULL,
          `empresa_id` INT NULL DEFAULT NULL,
          `cantidad_turno_horario` VARCHAR(45) NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `empresa_id` (`empresa_id`),
          CONSTRAINT `FK_proyecto_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `etapa_constructiva` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tarea` VARCHAR(45) NULL DEFAULT NULL,
          `descripcion` VARCHAR(875) NULL DEFAULT NULL,
          `insumo` VARCHAR(875) NULL DEFAULT NULL,
          `proyecto_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `proyecto_id` (`proyecto_id`),
          CONSTRAINT `FK_etapa_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `factor_afectacion` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `factor` VARCHAR(45) NULL DEFAULT NULL,
          `descripcion` VARCHAR(1800) NULL DEFAULT NULL,
          `caracterizacion_entorno_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `caracterizacion_entorno_id` (`caracterizacion_entorno_id`),
          CONSTRAINT `FK_factor_caracterizacion` FOREIGN KEY (`caracterizacion_entorno_id`) REFERENCES `caracterizacion_entorno` (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `etapa_operativa` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tarea` VARCHAR(45) NULL DEFAULT NULL,
          `descripcion` VARCHAR(875) NULL DEFAULT NULL,
          `proceso` VARCHAR(875) NULL DEFAULT NULL,
          `proyecto_id` INT NULL DEFAULT NULL,
          `materia_prima` VARCHAR(875) NULL DEFAULT NULL,
          `producto` VARCHAR(875) NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `proyecto_id` (`proyecto_id`),
          CONSTRAINT `FK_etapaOperativa_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `sub_tipo_residuo` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `nombre` VARCHAR(45) NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_residuo` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tipo` VARCHAR(45) NULL DEFAULT NULL,
          `sub_tipo_residuo_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `sub_tipo_residuo_id` (`sub_tipo_residuo_id`),
          CONSTRAINT `FK_tipo_residuo_sub_tipo` FOREIGN KEY (`sub_tipo_residuo_id`) REFERENCES `sub_tipo_residuo` (`id`)
        );");
        $this->addSQL("ALTER TABLE `residuo`
        ADD COLUMN `etapa_constructiva_id` INT NULL DEFAULT NULL AFTER `planta_id`,
        ADD COLUMN `etapa_operativa_id` INT NULL DEFAULT NULL AFTER `etapa_constructiva_id`,
        ADD COLUMN `tipo_residuo_id` INT NULL DEFAULT NULL AFTER `etapa_operativa_id`,
        ADD INDEX `etapa_constructiva_id` (`etapa_constructiva_id`),
        ADD INDEX `etapa_operativa_id` (`etapa_operativa_id`),
        ADD INDEX `tipo_residuo_id` (`tipo_residuo_id`),
        ADD CONSTRAINT `FK_etapa_constructiva_residuo` FOREIGN KEY (`etapa_constructiva_id`) REFERENCES `etapa_constructiva` (`id`),
        ADD CONSTRAINT `FK_etapa_operativa_residuo` FOREIGN KEY (`etapa_operativa_id`) REFERENCES `etapa_operativa` (`id`),
        ADD CONSTRAINT `FK_residuo_tipo_residuo` FOREIGN KEY (`tipo_residuo_id`) REFERENCES `tipo_residuo` (`id`);"
        );
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_efluente` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tipo` VARCHAR(45) NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        )
        ;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_emision` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tipo` VARCHAR(45) NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        )
        ;");
        $this->addSQL("ALTER TABLE `efluente`
        ADD COLUMN `etapa_constructiva_id` INT NULL DEFAULT NULL AFTER `planta_id`,
        ADD COLUMN `etapa_operativa_id` INT NULL DEFAULT NULL AFTER `etapa_constructiva_id`,
        ADD COLUMN `tipo_efluente_id` INT NULL DEFAULT NULL AFTER `etapa_operativa_id`,
        ADD COLUMN `nombre` VARCHAR(45) NULL DEFAULT NULL AFTER `tipo_efluente_id`,
        ADD COLUMN `tratamiento` VARCHAR(45) NULL DEFAULT NULL AFTER `nombre`,
        ADD COLUMN `caudal` VARCHAR(45) NULL DEFAULT NULL AFTER `tratamiento`,
        ADD INDEX `etapa_constructiva_id` (`etapa_constructiva_id`),
        ADD INDEX `etapa_operativa_id` (`etapa_operativa_id`),
        ADD INDEX `tipo_efluente_id` (`tipo_efluente_id`),
        ADD CONSTRAINT `FK_efluente_constructiva` FOREIGN KEY (`etapa_constructiva_id`) REFERENCES `etapa_constructiva` (`id`),
        ADD CONSTRAINT `FK_efluente_operativa` FOREIGN KEY (`etapa_operativa_id`) REFERENCES `etapa_operativa` (`id`),
        ADD CONSTRAINT `FK_efluente_tipo_efluente` FOREIGN KEY (`tipo_efluente_id`) REFERENCES `tipo_efluente` (`id`)
        ;");
        
        $this->addSQL("ALTER TABLE `emision_gaseosa`
        ADD COLUMN `etapa_constructiva_id` INT NULL DEFAULT NULL AFTER `planta_id`,
        ADD COLUMN `etapa_operativa_id` INT NULL DEFAULT NULL AFTER `etapa_constructiva_id`,
        ADD COLUMN `tipo_emision_id` INT NULL DEFAULT NULL AFTER `etapa_operativa_id`,
        ADD COLUMN `nombre` VARCHAR(45) NULL DEFAULT NULL AFTER `tipo_emision_id`,
        ADD COLUMN `funcionamiento` VARCHAR(45) NULL DEFAULT NULL AFTER `nombre`,
        ADD COLUMN `caudal` VARCHAR(45) NULL DEFAULT NULL AFTER `funcionamiento`,
        ADD COLUMN `chimenea` VARCHAR(45) NULL DEFAULT NULL AFTER `caudal`,
        ADD COLUMN `contaminante` VARCHAR(200) NULL DEFAULT NULL AFTER `chimenea`,
        ADD COLUMN `sitio` VARCHAR(45) NULL DEFAULT NULL AFTER `contaminante`,
        ADD INDEX `etapa_constructiva_id` (`etapa_constructiva_id`),
        ADD INDEX `etapa_operativa_id` (`etapa_operativa_id`),
        ADD INDEX `tipo_emision_id` (`tipo_emision_id`),
        ADD CONSTRAINT `FK_emision_constructiva` FOREIGN KEY (`etapa_constructiva_id`) REFERENCES `etapa_constructiva` (`id`),
        ADD CONSTRAINT `FK_emision_operativa` FOREIGN KEY (`etapa_operativa_id`) REFERENCES `etapa_operativa` (`id`),
        ADD CONSTRAINT `FK_emision_tipo_emision` FOREIGN KEY (`tipo_emision_id`) REFERENCES `tipo_emision` (`id`)
        ;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `uso_recurso` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `recurso` VARCHAR(45) NULL DEFAULT NULL,
          `extraccion` VARCHAR(875) NULL DEFAULT NULL,
          `proceso` VARCHAR(875) NULL DEFAULT NULL,
          `cantidad_tiempo` VARCHAR(875) NULL DEFAULT NULL,
          `proyecto_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `proyecto_id` (`proyecto_id`),
          CONSTRAINT `FK_recurso_proyecto` FOREIGN KEY (`proyecto_id`) REFERENCES `proyecto` (`id`)
        )
        ;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tipo_impacto` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tipo` VARCHAR(45) NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        )
        ;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `impacto` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `descripcion` VARCHAR(45) NULL DEFAULT NULL,
          `proceso` VARCHAR(45) NULL DEFAULT NULL,
          `contaminante_relevante` VARCHAR(45) NULL DEFAULT NULL,
          `medida_mitigacion` VARCHAR(45) NULL DEFAULT NULL,
          `plan_monitoreo` VARCHAR(45) NULL DEFAULT NULL,
          `medida_implementacion` VARCHAR(1800) NULL DEFAULT NULL,
          `plazo` VARCHAR(300) NULL DEFAULT NULL,
          `parametro_monitoreo` VARCHAR(300) NULL DEFAULT NULL,
          `frecuencia` VARCHAR(300) NULL DEFAULT NULL,
          `punto_muestreo` VARCHAR(300) NULL DEFAULT NULL,
          `normativa_referencia` VARCHAR(300) NULL DEFAULT NULL,
          `planta_id` INT NULL DEFAULT NULL,
          `tipo_impacto_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `planta_id` (`planta_id`),
          INDEX `tipo_impacto_id` (`tipo_impacto_id`),
          CONSTRAINT `FK_impacto_planta` FOREIGN KEY (`planta_id`) REFERENCES `planta` (`id`),
          CONSTRAINT `FK_impacto_tipo_impacto` FOREIGN KEY (`tipo_impacto_id`) REFERENCES `tipo_impacto` (`id`)
        )
        ;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `riesgo` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `categorizacion` VARCHAR(2600) NULL DEFAULT NULL,
          `plan_contingencia` VARCHAR(4400) NULL DEFAULT NULL,
          `planta_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `planta_id` (`planta_id`),
          CONSTRAINT `FK_riesgo_planta` FOREIGN KEY (`planta_id`) REFERENCES `planta` (`id`)
        )
        ;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `marco_legal` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tipo_norma` VARCHAR(100) NULL DEFAULT NULL,
          `tema` VARCHAR(200) NULL DEFAULT NULL,
          `aplicacion_especifica` VARCHAR(500) NULL DEFAULT NULL,
          `empresa_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `empresa_id` (`empresa_id`),
          CONSTRAINT `FK_marco_empresa` FOREIGN KEY (`empresa_id`) REFERENCES `empresa` (`id`)
        )
        ;");
        $this->addSQL("ALTER TABLE `sustancia_riesgosa`
        CHANGE COLUMN `nombre` `nombre` VARCHAR(250) NULL DEFAULT NULL COLLATE 'utf8_unicode_ci' AFTER `id`,
        CHANGE COLUMN `cantidad` `cantidad` FLOAT NULL DEFAULT NULL AFTER `nombre`,
        ADD COLUMN `planta_id` INT NULL DEFAULT NULL AFTER `cantidad`,
        ADD INDEX `planta_id` (`planta_id`),
        ADD CONSTRAINT `FK_sustancia_planta` FOREIGN KEY (`planta_id`) REFERENCES `planta` (`id`);"
        );
        $this->addSQL("CREATE TABLE IF NOT EXISTS `empresaHasActividad` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `tipo` TINYINT NULL DEFAULT NULL,
          `empresa_id` INT(11) NULL DEFAULT NULL,
          `actividad_id` INT(11) NULL DEFAULT NULL,
          PRIMARY KEY (`id`),
          INDEX `empresa_id` (`empresa_id`),
          INDEX `actividad_id` (`actividad_id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `categoria_residuo_peligroso` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `categoria` VARCHAR(45) NULL DEFAULT NULL,
          `nombre` VARCHAR(45) NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        )
        ;");
        $this->addSQL("ALTER TABLE `residuo`
        ADD COLUMN `categoria_residuo_peligroso_id` INT NULL DEFAULT NULL AFTER `tipo_residuo_id`,
        ADD COLUMN `estado_fisico` VARCHAR(45) NULL DEFAULT NULL AFTER `categoria_residuo_peligroso_id`;");

        $this->addSQL("CREATE TABLE IF NOT EXISTS `medida_eficiencia` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `medida` VARCHAR(2600) NULL DEFAULT NULL,
          `planta_id` INT NULL DEFAULT NULL,
          PRIMARY KEY (`id`)
        );");
        $this->addSQL("CREATE TABLE IF NOT EXISTS area_medio_urbanizacion (id INT AUTO_INCREMENT NOT NULL, actividadIndustrial INT DEFAULT NULL, actividadServicio INT DEFAULT NULL, actividadAgropecuaria INT DEFAULT NULL, plantaTratamiento INT DEFAULT NULL, actividadPecuaria INT DEFAULT NULL, criaGanado INT DEFAULT NULL, aveCorral INT DEFAULT NULL, proximidadRuta INT DEFAULT NULL, transportePublico INT DEFAULT NULL, ferrocarriles INT DEFAULT NULL, aeropuerto INT DEFAULT NULL, actividadAgricola INT DEFAULT NULL, vertederosRsu INT DEFAULT NULL, generacionResiduo INT DEFAULT NULL, otros VARCHAR(45) DEFAULT NULL, urbanizacion_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS area_urbanizacion_medio (id INT AUTO_INCREMENT NOT NULL, ofertaNuevaVivienda INT DEFAULT NULL, aspectoSocioEconomico INT DEFAULT NULL, incrementoTraficoVehicular INT DEFAULT NULL, afectacionMedioFisico INT DEFAULT NULL, usoAguasSubterranea INT DEFAULT NULL, otros VARCHAR(45) DEFAULT NULL, urbanizacion_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS area_natural_protegida (id INT AUTO_INCREMENT NOT NULL, ribera INT DEFAULT NULL, crestaBarranca INT DEFAULT NULL, otros VARCHAR(45) DEFAULT NULL, urbanizacion_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS afectacion_a (id INT AUTO_INCREMENT NOT NULL, aspectoBiotico INT DEFAULT NULL, coberturaVegetal INT DEFAULT NULL, fauna INT DEFAULT NULL, otros VARCHAR(45) DEFAULT NULL, urbanizacion_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS servidumbre_ambiental (id INT AUTO_INCREMENT NOT NULL, electroducto INT DEFAULT NULL, gas INT DEFAULT NULL, hidrica INT DEFAULT NULL, otros VARCHAR(45) DEFAULT NULL, urbanizacion_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8;");
        $this->addSQL("CREATE TABLE IF NOT EXISTS medida_preventiva (id INT AUTO_INCREMENT NOT NULL, infraestructuraSaneamiento VARCHAR(255) DEFAULT NULL, descripcionMitigacionImpacto VARCHAR(255) DEFAULT NULL, urbanizacion_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8;");
    }
    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE actividad');
        $this->addSql('DROP TABLE departamento');
        $this->addSql('DROP TABLE dimensionamiento_planta');
        $this->addSql('DROP TABLE domicilio');
        $this->addSql('DROP TABLE efluente');
        $this->addSql('DROP TABLE emision_gaseosa');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE empresaHasActividad');
        $this->addSql('DROP TABLE empresaHasPerito');
        $this->addSql('DROP TABLE empresaHasRepresentante');
        $this->addSql('DROP TABLE formacion_personal');
        $this->addSql('DROP TABLE formulario');
        $this->addSql('DROP TABLE grupo');
        $this->addSql('DROP TABLE inmueble_anexo');
        $this->addSql('DROP TABLE insumo');
        $this->addSql('DROP TABLE listaTramites');
        $this->addSql('DROP TABLE localidad');
        $this->addSql('DROP TABLE materia_prima');
        $this->addSql('DROP TABLE migration_versions');
        $this->addSql('DROP TABLE partida_inmobiliaria');
        $this->addSql('DROP TABLE perito');
        $this->addSql('DROP TABLE persona');
        $this->addSql('DROP TABLE planta');
        $this->addSql('DROP TABLE producto');
        $this->addSql('DROP TABLE provincia');
        $this->addSql('DROP TABLE representante');
        $this->addSql('DROP TABLE residuo');
        $this->addSql('DROP TABLE riesgo_presunto');
        $this->addSql('DROP TABLE servicio');
        $this->addSql('DROP TABLE subproducto');
        $this->addSql('DROP TABLE sustancia_auxiliar');
        $this->addSql('DROP TABLE sustancia_riesgosa');
        $this->addSql('DROP TABLE tanque');
        $this->addSql('DROP TABLE tramite');
        $this->addSql('DROP TABLE resumen_ejecutivo');
        $this->addSql('DROP TABLE caracterizacion_entorno');
        $this->addSql('DROP TABLE etapa_constructiva');
        $this->addSql('DROP TABLE factor_afectacion');
        $this->addSql('DROP TABLE etapa_operativa');
        $this->addSql('DROP TABLE sub_tipo_residuo');
        $this->addSql('DROP TABLE tipo_residuo');
        $this->addSql('DROP TABLE tipo_efluente');
        $this->addSql('DROP TABLE tipo_emision');
        $this->addSql('DROP TABLE uso_recurso');
        $this->addSql('DROP TABLE tipo_impacto');
        $this->addSql('DROP TABLE impacto');
        $this->addSql('DROP TABLE riesgo');
        $this->addSql('DROP TABLE marco_legal');
        $this->addSql('DROP TABLE categoria_residuo_peligroso');
        $this->addSql('DROP TABLE medida_eficiencia');
        $this->addSql('DROP TABLE area_medio_urbanizacion');
        $this->addSql('DROP TABLE area_urbanizacion_medio');
        $this->addSql('DROP TABLE area_natural_protegida');
        $this->addSql('DROP TABLE afectacion_a');
        $this->addSql('DROP TABLE servidumbre_ambiental');
        $this->addSql('DROP TABLE medida_preventiva');
    }
}


