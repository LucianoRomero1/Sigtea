<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210914011047 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
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

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE proyecto');

    }
}
