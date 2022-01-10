<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210630153804 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO tipo_impacto (tipo) VALUES ('suelo');");
        $this->addSql("INSERT INTO tipo_impacto (tipo) VALUES ('agua');");
        $this->addSql("INSERT INTO tipo_impacto (tipo) VALUES ('aire');");
        $this->addSql("INSERT INTO tipo_impacto (tipo) VALUES ('cuerporeceptor');");
        $this->addSql("INSERT INTO tipo_impacto (tipo) VALUES ('otro_impacto');");

    }

    public function down(Schema $schema) : void
    {
        $this->addSql("TRUNCATE TABLE tipo_impacto;");

    }
}
