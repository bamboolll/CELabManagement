
-- -----------------------------------------------------
-- Table `DeviceName`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `DeviceName` (
  `device_id` INT NOT NULL ,
  `device_name` VARCHAR(80) NULL ,
  `no_total` INT NULL ,
  `no_available` INT NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`device_id`) )
;


-- -----------------------------------------------------
-- Table `DeviceUnit`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `DeviceUnit` (
  `unit_id` INT NOT NULL ,
  `device_id` INT NULL ,
  `unit_code` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`unit_id`) );


-- -----------------------------------------------------
-- Table `Tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Tag` (
  `tag_id` INT NOT NULL ,
  `tag_name` VARCHAR(80) NULL ,
  `tag_description` TEXT NULL ,
  PRIMARY KEY (`tag_id`) );


-- -----------------------------------------------------
-- Table `Device_Tag`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `Device_Tag` (
  `unit_id` INT NOT NULL ,
  `tag_id` INT NOT NULL ,
  PRIMARY KEY (`unit_id`, `tag_id`) );


-- -----------------------------------------------------
-- Table `BorrowType`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BorrowType` (
  `type_id` INT NOT NULL ,
  `type_name` VARCHAR(80) NULL ,
  `description` TEXT NULL ,
  PRIMARY KEY (`type_id`) );


-- -----------------------------------------------------
-- Table `BorrowStatus`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `BorrowStatus` (
  `status_id` INT NOT NULL ,
  `status_name` VARCHAR(45) NULL ,
  `status_description` TEXT NULL ,
  PRIMARY KEY (`status_id`) );


-- -----------------------------------------------------
-- Table `LabLog`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `LabLog` (
  `log_id` INT NOT NULL ,
  `unit_id` INT NOT NULL ,
  `borrower_name` VARCHAR(80) NOT NULL ,
  `borrower_id` VARCHAR(45) NULL ,
  `receive_date` DATETIME NOT NULL ,
  `return_date` DATETIME NULL ,
  `borrow_type` INT NOT NULL ,
  `status_id` INT NULL ,
  PRIMARY KEY (`log_id`) );
