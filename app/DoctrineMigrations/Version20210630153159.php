<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210630153159 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS impacto (id INT AUTO_INCREMENT NOT NULL, planta_id INT DEFAULT NULL, tipo_impacto_id INT DEFAULT NULL, descripcion VARCHAR(255) NOT NULL, proceso VARCHAR(255) NOT NULL, contamienate_relevante VARCHAR(255) DEFAULT NULL, medida_mitigacion VARCHAR(255) DEFAULT NULL, plan_monitoreo VARCHAR(255) DEFAULT NULL, medida_implementacion VARCHAR(1000) DEFAULT NULL, plazo VARCHAR(255) DEFAULT NULL, parametro_monitoreo VARCHAR(255) DEFAULT NULL, frecuencia VARCHAR(255) DEFAULT NULL, punto_muestreo VARCHAR(255) DEFAULT NULL, normativa_referencia VARCHAR(255) DEFAULT NULL, caudal VARCHAR(255) DEFAULT NULL,cuerpo_receptor VARCHAR(255) DEFAULT NULL,prevencion VARCHAR(255) DEFAULT NULL,consecuencia VARCHAR(255) DEFAULT NULL, INDEX IDX_91AF0F27981981BF (planta_id), INDEX IDX_91AF0F27B34355A (tipo_impacto_id), PRIMARY KEY(id));
        CREATE TABLE IF NOT EXISTS tipo_agua (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) ;
        CREATE TABLE IF NOT EXISTS tipo_impacto (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, PRIMARY KEY(id)) ;");
        $this->addSql("ALTER TABLE agua CHANGE tipo tipo INT DEFAULT NULL, CHANGE nombre nombre VARCHAR(50) DEFAULT NULL, CHANGE ubicacionPlano ubicacionPlano VARCHAR(100) DEFAULT NULL, CHANGE cantidad cantidad DOUBLE PRECISION DEFAULT NULL, CHANGE unidad unidad VARCHAR(50) DEFAULT NULL, CHANGE tiempo tiempo VARCHAR(50) DEFAULT NULL;
        ALTER TABLE almacenamiento_tanque CHANGE tipo_almacenamiento_id tipo_almacenamiento_id INT DEFAULT NULL, CHANGE numero numero INT NOT NULL, CHANGE tipo_tanque tipo_tanque VARCHAR(255) NOT NULL, CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE descripcion descripcion VARCHAR(255) NOT NULL, CHANGE sustancia sustancia VARCHAR(255) NOT NULL, CHANGE capacidad capacidad INT NOT NULL, CHANGE planta_id planta_id INT DEFAULT NULL, CHANGE presion presion VARCHAR(50) NOT NULL;
        ALTER TABLE electrica_adquirida CHANGE recurso_id recurso_id INT DEFAULT NULL;
        ALTER TABLE electrica_propia CHANGE recurso_id recurso_id INT DEFAULT NULL;
        ALTER TABLE otro_recurso CHANGE recurso_id recurso_id INT DEFAULT NULL;
        ALTER TABLE recurso CHANGE planta_Id planta_id INT DEFAULT NULL;");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE impacto;");
        $this->addSql("DROP TABLE tipo_agua;");
        $this->addSql("DROP TABLE tipo_impacto;");

    }
}
