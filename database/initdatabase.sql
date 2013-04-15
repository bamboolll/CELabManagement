SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `mydb` ;
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`DeviceName`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`DeviceName` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`DeviceName` (
  `device_id` INT NOT NULL ,
  `device_name` VARCHAR(80) NULL ,
  `no_total` INT NULL ,
  `no_available` INT NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`device_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`DeviceUnit`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`DeviceUnit` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`DeviceUnit` (
  `unit_id` INT NOT NULL ,
  `device_id` INT NULL ,
  `unit_code` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`unit_id`) )
ENGINE = InnoDB
COMMENT = 'Store all device instances';


-- -----------------------------------------------------
-- Table `mydb`.`Tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Tag` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Tag` (
  `tag_id` INT NOT NULL ,
  `tag_name` VARCHAR(80) NULL ,
  `tag_description` TEXT NULL ,
  PRIMARY KEY (`tag_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Device_Tag`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`Device_Tag` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`Device_Tag` (
  `unit_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  PRIMARY KEY (`unit_id`, `tag_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`BorrowType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`BorrowType` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`BorrowType` (
  `type_id` INT NOT NULL ,
  `type_name` VARCHAR(80) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`type_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`LabLog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`LabLog` ;

CREATE  TABLE IF NOT EXISTS `mydb`.`LabLog` (
  `log_id` INT NOT NULL ,
  `unit_id` INT NOT NULL ,
  `borrower_name` VARCHAR(80) NOT NULL ,
  `borrower_id` VARCHAR(45) NULL ,
  `receive_date` DATETIME NOT NULL ,
  `return_date` DATETIME NULL ,
  `borrow_type` INT NOT NULL ,
  PRIMARY KEY (`log_id`) )
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
