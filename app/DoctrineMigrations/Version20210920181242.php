<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210920181242 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("UPDATE `listaTramites` SET `descripcion`='Loteo con fines de Urbanización: IAC', `url`='formularioc1' WHERE `id`=10;");
        $this->addSql("UPDATE `listaTramites` SET `url`='formularioExpendioCombustibleIAC' WHERE  `id`=7;");
        $this->addSql("UPDATE `listaTramites` SET `descripcion`='Combusitble: Formulario de Presentación', `url`='formularioExpendioCombustiblePresentacion' WHERE  `id`=11;");
        $this->addSql("UPDATE `listaTramites` SET `descripcion`='Combusitble: Estudio de Impacto Ambiental',`url`='formularioExpendioCombustibleEsIA' WHERE  `id`=12;");
        $this->addSql("UPDATE `listaTramites` SET `descripcion`='Acopios de granos: IAC', `url`='formularioAcopioGranosIAC' WHERE  `id`=13;");
        $this->addSql("INSERT INTO `listaTramites` (`descripcion`, `url`) VALUES ('Acopios de granos: EsIA', 'formularioAcopioGranosEsIA');");
        $this->addSql("INSERT INTO `listaTramites` (`descripcion`, `url`) VALUES ('Feed Lots: Presentación de Declaración Jurada', 'formularioFeedLotsPresentacion');");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("");

    }
}
