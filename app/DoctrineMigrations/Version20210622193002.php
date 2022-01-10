<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622193002 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("INSERT INTO `tipo_almacenamiento` (`nombre`) VALUES ('aereo')");
        $this->addSQL("INSERT INTO `tipo_almacenamiento` (`nombre`) VALUES ('subterraneo')");
        $this->addSQL("INSERT INTO `tipo_almacenamiento` (`nombre`) VALUES ('otro')");

    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("TRUNCATE TABLE `tipo_almacenamiento`");

    }
}
