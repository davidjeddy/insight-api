<?php

use yii\db\Migration;

class m170827072441_AddLocationToStore extends Migration
{
    public function safeUp()
    {
        echo __CLASS__ . ' ' . __METHOD__ . "\n";

        $command = "
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `store` 
ADD COLUMN `lati` VARCHAR(16) NULL AFTER `manager_id`,
ADD COLUMN `long` VARCHAR(16) NULL AFTER `lati`;

            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ";

        $this->execute($command);
    }

    public function safeDown()
    {
        echo __CLASS__ . ' ' . __METHOD__ . "\n";

        $command = "
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `store` 
DROP COLUMN `long`,
DROP COLUMN `lati`;

            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ";

        $this->execute($command);
    }
}
