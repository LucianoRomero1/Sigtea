<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210803193746 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `tramite` ADD COLUMN `empresa_id` INT NULL;');

    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE `tramite` DROP COLUMN `empresa_id`;');

    }
}
