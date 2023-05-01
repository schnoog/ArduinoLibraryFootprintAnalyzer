
DROP TABLE IF EXISTS `libs`, `platform`, `testresults`;


CREATE TABLE `ArduLibTest`.`libs` ( `id` INT NOT NULL AUTO_INCREMENT , `lib_name` VARCHAR(255) DEFAULT NULL , `lib_url` VARCHAR(1024) NOT NULL , `lib_version` VARCHAR(32) DEFAULT NULL, `lib_depends` VARCHAR(2048) DEFAULT NULL, `lib_architectures` VARCHAR(2048) DEFAULT NULL, `lib_lastcheck` INT NOT NULL DEFAULT '0', `lib_minprogspace` INT NOT NULL DEFAULT '0', `lib_mindynspace` INT NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `ArduLibTest`.`libs` ADD UNIQUE `UniqLibVer` (`lib_url`, `lib_version`);


CREATE TABLE `ArduLibTest`.`testresults` ( `id` INT NOT NULL AUTO_INCREMENT , `lib_id` INT NOT NULL , `platform_id` INT NOT NULL , `example` VARCHAR(255) NOT NULL , `program_space` INT NOT NULL , `dynamic_space` INT NOT NULL , `test_valid` INT(1) NOT NULL DEFAULT '0' , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `ArduLibTest`.`testresults` ADD UNIQUE `uniq_platform_example_test` (`lib_id`, `platform_id`, `example`);


CREATE TABLE `ArduLibTest`.`platform` ( `id` INT NOT NULL AUTO_INCREMENT , `platform` VARCHAR(255) NOT NULL , `platform_label` VARCHAR(1024) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
ALTER TABLE `ArduLibTest`.`platform` ADD UNIQUE `uniq_pf` (`platform`);





