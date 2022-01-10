<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210809200509 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Residuo Solido Urbano");');
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Residuo Peligroso");');
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Residuo Industrial No Peligroso");');
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Residuo Patologico");');
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Otro Residuo");');
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Estiercol");');
        $this->addSQL('INSERT INTO `tipo_residuo` (`tipo`) VALUES ("Residuo Solido Urbano");');        

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE `tipo_residuo`');

    }
}
