<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210617211843 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {   
        $this->addSQL("CREATE TABLE IF NOT EXISTS `fos_user`(
            `id` INT(11) NOT NULL AUTO_INCREMENT,
            `username` VARCHAR(180) NOT NULL,
            `username_canonical` VARCHAR(180) NOT NULL,
            `email` VARCHAR(180) NOT NULL,
            `email_canonical` VARCHAR(180) NOT NULL,
            `enabled` TINYINT(1) NOT NULL,
            `salt` VARCHAR(255) DEFAULT NULL,
            `password` VARCHAR(255) NOT NULL,
            `last_login` DATETIME DEFAULT NULL,
            `confirmation_token` VARCHAR(180) DEFAULT NULL,
            `password_requested_at` DATETIME DEFAULT NULL,
            `roles` LONGTEXT NOT NULL,
            PRIMARY KEY (`id`)
        );");
         
    }

    public function down(Schema $schema) : void
    {
        $this->addSQL("DELETE TABLE `fos_user`");

    }
}
