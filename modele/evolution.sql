
ALTER TABLE `bateau` ADD `photo` VARCHAR(100) NULL DEFAULT NULL AFTER `nom`; 

UPDATE `bateau` SET `photo` = 'images/bateaux/korAnt.jpg' WHERE `bateau`.`id` = 1; 
UPDATE `bateau` SET `photo` = 'images/bateaux/ArSolen.jpg' WHERE `bateau`.`id` = 2; 
UPDATE `bateau` SET `photo` = 'images/bateaux/alXi.jpg' WHERE `bateau`.`id` = 3; 
UPDATE `bateau` SET `photo` = 'images/bateaux/luceIsle.jpg' WHERE `bateau`.`id` = 4; 
UPDATE `bateau` SET `photo` = 'images/bateaux/maellys.jpg' WHERE `bateau`.`id` = 5; 


