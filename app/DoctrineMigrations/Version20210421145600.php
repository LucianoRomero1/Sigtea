<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421145600 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `storage` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `uid` VARCHAR(100) NULL DEFAULT NULL,
            `nombre` VARCHAR(100) NULL DEFAULT NULL,
            `estado` VARCHAR(100) NULL DEFAULT NULL,
            `observaciones` VARCHAR(255) NULL DEFAULT NULL,
            `inciso` VARCHAR(45) NULL DEFAULT NULL,
            `tramite_id` INT NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");
        $this->addSql("CREATE TABLE IF NOT EXISTS `entidad_has_repositorio` (
            `id` INT NOT NULL AUTO_INCREMENT,
            `entidad_id` INT NULL DEFAULT NULL,
            `entidad` VARCHAR(45) NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
        );");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE storage");
        $this->addSql("DROP TABLE entidad_has_repositorio");

    }
}
