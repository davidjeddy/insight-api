<?php

use yii\db\Migration;

class M170827072450_AddLocationDataToStore extends Migration
{
    public function safeUp()
    {
        echo __CLASS__ . ' ' . __METHOD__ . "\n";

        $command = "
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


update store
SET `lati` = '28.054400', `long` = '-82.513200'
WHERE id = 2;

update store
SET `lati` = '28.017389', `long` = '-82.734267'
WHERE id = 3;

update store
SET `lati` = '27.890814', `long` = '-82.502346'
WHERE id = 7;

update store
SET `lati` = '28.182893', `long` = '-82.364175'
WHERE id = 10;-82.502346

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

TRUNCATE store;

            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ";

        $this->execute($command);
    }
}
