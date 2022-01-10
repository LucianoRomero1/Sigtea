<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817224820 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("UPDATE listaTramites SET url='formularioUrbanizacionPresentacion' WHERE  `id`=1;");
        $this->addSQL("UPDATE listaTramites SET url='formularioIndustriasPresentacion' WHERE  `id`=4;");
        $this->addSQL("UPDATE listaTramites SET url='formularioAcopioGranosEstudioImpactoAmbiental' WHERE  `id`=6;");
        $this->addSQL("UPDATE listaTramites SET url='formularioExpendioCombustiblePresentacion' WHERE  `id`=7;");
        $this->addSQL("UPDATE listaTramites SET url='formularioFeedLotsInformeAmbientalCumplimiento' WHERE  `id`=8;");
        $this->addSQL("UPDATE listaTramites SET url='formularioFeedLotsInformeAmbientalCumplimiento' WHERE  `id`=9;");
    }

    public function down(Schema $schema) : void
    {
       
    }
}
