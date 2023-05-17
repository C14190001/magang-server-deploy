# Dashboard untuk Magang
## Catatan
- Log Off di Client akan dianggap status OFF.

## Kode Database
 `* adalah Primary Key`

> Admins

Username, Password (di MD5)

 ``CREATE TABLE `magang-database`.`admins` (`admin_id` INT(5) NOT NULL AUTO_INCREMENT , `username` VARCHAR(30) NOT NULL , `password` VARCHAR(1000) NOT NULL , PRIMARY KEY (`admin_id`)) ENGINE = InnoDB;``

> Clients

ID*, Updated?

``CREATE TABLE `magang-database`.`clients` (`id` INT(5) NOT NULL AUTO_INCREMENT , `updated?` BOOLEAN NOT NULL DEFAULT FALSE , PRIMARY KEY (`id`)) ENGINE = InnoDB;``

> Client Specs

ID*, PC name, CPU, iGPU, ExtGPU, Total RAM, Total Memory (HDD), IP Address, MAC Address

``CREATE TABLE `magang-database`.`client_specs` (`id` INT(5) NOT NULL, `name` VARCHAR(30) NOT NULL , `cpu` VARCHAR(50) NOT NULL , `i-gpu` VARCHAR(30) NOT NULL , `e-gpu` VARCHAR(30) NOT NULL DEFAULT "N/A" , `ram` INT(5) NOT NULL , `memory` INT(5) NOT NULL , `ip` VARCHAR(150) NOT NULL , `mac` VARCHAR(150) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;``

> Client Status

ID, Status, Date Time 

``CREATE TABLE `magang-database`.`client_status` (`id` INT(5) NOT NULL, `status` VARCHAR(15) NOT NULL , `date_time` DATETIME(0) NOT NULL DEFAULT CURRENT_TIMESTAMP) ENGINE = InnoDB;``

> Client Apps
> 
ID*, Apps (A, B, C, .dst)

``CREATE TABLE `magang-database`.`client_apps` (`id` INT(5) NOT NULL, `apps` VARCHAR(10000) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;``
