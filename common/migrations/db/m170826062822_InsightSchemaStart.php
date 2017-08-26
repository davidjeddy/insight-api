<?php

use yii\db\Migration;

class m170826062822_InsightSchemaStart extends Migration
{
    public function safeUp()
    {
        echo __CLASS__ . ' ' . __METHOD__ . "\n";

        $command = "
            SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
            SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
            SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP TABLE IF EXISTS `payment`;
DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS `store`;
DROP TABLE IF EXISTS `managers`;
DROP TABLE IF EXISTS `customer`;

# customer
CREATE TABLE `customer` (
    customer_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    role varchar(75) not null,
    username varchar(75) not null
) ENGINE=innodb;

# managers
CREATE TABLE `managers` (
    manager_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name varchar(75) not null,
    last_name varchar(75) not null,
    cell_number varchar(20),
    email varchar(100)
) ENGINE=innodb;

# store
CREATE TABLE `store` (
    store_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(75) not null,
    zip int not null,
    manager_id int not null,
    FOREIGN KEY (manager_id) REFERENCES managers(manager_id)
) ENGINE=innodb;

# order
CREATE TABLE `order` (
    order_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_date TIMESTAMP not null, 
    store_id int not null,
    total_amount DECIMAL(19,4) not null, 
    total_wo_tax DECIMAL(19,4) not null,
    cart_discount_amt DECIMAL(19,4) not null, 
    order_total_tax DECIMAL(19,4), 
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY (store_id) REFERENCES store(store_id)
) ENGINE=innodb;

# payment
CREATE TABLE `payment` (
    payment_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    total_amount DECIMAL(19,4) not null, 
    status tinyint not null, 
    order_id int not null,
    customer_id int not null,
    del_date TIMESTAMP not null,
    FOREIGN KEY (customer_id) REFERENCES customer(customer_id),
    FOREIGN KEY (order_id) REFERENCES `order`(order_id)
) ENGINE=innodb;

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

DROP TABLE IF EXISTS `payment`;
DROP TABLE IF EXISTS `order`;
DROP TABLE IF EXISTS `store`;
DROP TABLE IF EXISTS `managers`;
DROP TABLE IF EXISTS `customer`;

            SET SQL_MODE=@OLD_SQL_MODE;
            SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
            SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
        ";

        $this->execute($command);
    }
}