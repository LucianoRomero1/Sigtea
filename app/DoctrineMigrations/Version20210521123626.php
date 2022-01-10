<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210521123626 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("DROP TABLE IF EXISTS `tanque`");
        $this->addSQL("CREATE TABLE IF NOT EXISTS `tanque`(
            `id` INT NOT NULL AUTO_INCREMENT,
            `cantidad` INT DEFAULT NULL,
            `capacidad_total` INT DEFAULT NULL,
            `unidad` VARCHAR(50) DEFAULT NULL,
            `planta_id` INT DEFAULT NULL,
            PRIMARY KEY (`id`)
        )");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("DROP TABLE IF EXISTS `tanque`");
        $this->addSql("CREATE TABLE IF NOT EXISTS `tanque` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `estado` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `fecha_creacion` date NOT NULL,
            `fecha_modificacion` date NOT NULL,
            `planta_id` INT NOT NULL DEFAULT,
            PRIMARY KEY (`id`)
          )");

    }
}
