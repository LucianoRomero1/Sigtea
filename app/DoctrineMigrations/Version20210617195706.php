<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617195706 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('CREATE TABLE IF NOT EXISTS agua (id INT AUTO_INCREMENT NOT NULL, recurso_id INT NOT NULL, tipo INT NOT NULL, nombre VARCHAR(50) NULL, ubicacionPlano VARCHAR(100) NULL, cantidad DOUBLE PRECISION NULL, unidad VARCHAR(50) NULL, tiempo VARCHAR(50) NULL, nro_perforacion INT NULL, PRIMARY KEY(id)) ');
        $this->addSql('CREATE TABLE IF NOT EXISTS almacenamiento_tanque (id INT AUTO_INCREMENT NOT NULL, tipo_almacenamiento_id INT NOT NULL, numero INT NULL, tipo_tanque VARCHAR(255) NULL, nombre VARCHAR(255) NULL, descripcion VARCHAR(255)  NULL, sustancia VARCHAR(255)  NULL, capacidad INT NULL,presion VARCHAR(255) NULL, planta_id INT NOT NULL, PRIMARY KEY(id)) ');
        $this->addSql('CREATE TABLE IF NOT EXISTS recurso (id INT AUTO_INCREMENT NOT NULL, tipo INT DEFAULT NULL, planta_id INT NOT NULL, PRIMARY KEY(id)) ');
        $this->addSql('CREATE TABLE IF NOT EXISTS tipo_almacenamiento (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, PRIMARY KEY(id)) ');
        $this->addSQL('CREATE TABLE IF NOT EXISTS electrica_propia (id INT AUTO_INCREMENT NOT NULL, metodo VARCHAR(255) NOT NULL, consumo FLOAT NOT NULL, fuente VARCHAR(255) NOT NULL, recurso_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSQL('CREATE TABLE IF NOT EXISTS electrica_adquirida (id INT AUTO_INCREMENT NOT NULL, nombre VARCHAR(255) NOT NULL, cantidad FLOAT NOT NULL, recurso_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSQL('CREATE TABLE IF NOT EXISTS otro_recurso (id INT AUTO_INCREMENT NOT NULL, tipo VARCHAR(255) NOT NULL, extraccion_captacion VARCHAR(255) NULL, etapa_proceso VARCHAR(255) NULL, cantidad_tiempo VARCHAR(255) NULL, nombre_anexo VARCHAR(255) NULL, recurso_id INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE `agua`");
        $this->addSql("DROP TABLE `almacenamiento_tanque`");
        $this->addSql("DROP TABLE `recurso`");
        $this->addSql("DROP TABLE `tipo_almacenamiento`");
        $this->addSql("DROP TABLE `otro_recurso`");
        $this->addSql("DROP TABLE `electrica_propia`");
        $this->addSql("DROP TABLE `electrica_adquirida`");
    }
}
