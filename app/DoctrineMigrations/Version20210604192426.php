<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210604192426 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("INSERT INTO `estado` (`descripcion`) VALUES ('INICIADO')");
        $this->addSQL("INSERT INTO `estado` (`descripcion`) VALUES ('EN_REVICION')");
        $this->addSQL("INSERT INTO `estado` (`descripcion`) VALUES ('OBSERVADO')");
        $this->addSQL("INSERT INTO `estado` (`descripcion`) VALUES ('RECHAZADO')");
        $this->addSQL("INSERT INTO `estado` (`descripcion`) VALUES ('FINALIZADO')");
    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("TRUNCATE TABLE `estado`");

    }
}
