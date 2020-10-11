
ALTER TABLE `bateau` ADD `photo` VARCHAR(100) NULL DEFAULT NULL AFTER `nom`; 

UPDATE `bateau` SET `photo` = 'korAnt.jpg' WHERE `bateau`.`id` = 1; 
UPDATE `bateau` SET `photo` = 'ArSolen.jpg' WHERE `bateau`.`id` = 2; 
UPDATE `bateau` SET `photo` = 'alXi.jpg' WHERE `bateau`.`id` = 3; 
UPDATE `bateau` SET `photo` = 'luceIsle.jpg' WHERE `bateau`.`id` = 4; 
UPDATE `bateau` SET `photo` = 'maellys.jpg' WHERE `bateau`.`id` = 5; 