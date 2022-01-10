<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210716201020 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL("DELETE FROM `listaTramites` WHERE  `id`=7;");
        $this->addSQL("UPDATE `listaTramites` SET `id`='7' WHERE  `id`=8;");
        $this->addSQL("UPDATE `listaTramites` SET `id`='8' WHERE  `id`=9;");
        $this->addSQL("UPDATE `listaTramites` SET `id`='9' WHERE  `id`=10;");
        $this->addSQL("UPDATE `listaTramites` SET `id`='10' WHERE  `id`=11;");
        $this->addSQL("UPDATE `listaTramites` SET `id`='11' WHERE  `id`=12;");
        $this->addSQL("UPDATE `listaTramites` SET `id`='12' WHERE  `id`=13");
        $this->addSQL("UPDATE `listaTramites` SET `id`='13' WHERE  `id`=14");

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
