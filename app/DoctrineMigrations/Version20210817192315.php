<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210817192315 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS tramite_planta_expendio (`id` int(11) NOT NULL AUTO_INCREMENT,`item` int(11) NULL,`nombre` varchar(255) NULL,`numero_registro` int(11) NULL,`numero_destruccion` int(11) NULL,`empresa_transportadora` varchar(255) NULL,`disposicion_final` varchar(255) NULL,`residuo_id` int(11) NOT NULL,PRIMARY KEY (`id`))");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE TABLE `tramite_planta_expendio`");

    }
}
