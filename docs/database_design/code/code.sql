-- MySQL Script generated by MySQL Workbench
-- Sun 21 Feb 2016 10:22:53 AM EET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema quizapp
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `quizapp` ;

-- -----------------------------------------------------
-- Schema quizapp
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `quizapp` DEFAULT CHARACTER SET utf8 ;
USE `quizapp` ;

-- -----------------------------------------------------
-- Table `quizapp`.`AccessLevel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`AccessLevel` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`AccessLevel` (
  `id` INT(1) NOT NULL AUTO_INCREMENT COMMENT 'Auto increment access level id',
  `name` VARCHAR(20) NOT NULL COMMENT 'Access level name',
  `updated` TIMESTAMP NOT NULL COMMENT 'Access level updated time.',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`User` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`User` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Auto increment user id',
  `email` VARCHAR(50) NOT NULL COMMENT 'User email address. used as username',
  `password` VARCHAR(255) NOT NULL COMMENT 'User password.Used for the login system.',
  `access` INT(1) NOT NULL COMMENT 'Access level id (Access:id)',
  `name` VARCHAR(40) NOT NULL COMMENT 'The real name from a user',
  `surname` VARCHAR(40) NOT NULL COMMENT 'The real surname from a user',
  `gender` INT(1) NOT NULL,
  `country` VARCHAR(40) NOT NULL COMMENT 'Country name where the user lives.Can be null',
  `city` VARCHAR(40) NOT NULL COMMENT 'City name where the user lives.Can be null',
  `address` VARCHAR(50) NOT NULL COMMENT 'Home address from a user.Can be null',
  `phone` VARCHAR(15) NULL COMMENT 'The phone number from a user.Can be null',
  `last_login` TIMESTAMP NOT NULL COMMENT 'Last login date from the user.',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  INDEX `alvl_idx` (`access` ASC),
  CONSTRAINT `access_level_id`
    FOREIGN KEY (`access`)
    REFERENCES `quizapp`.`AccessLevel` (`id`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`Questionnaire`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`Questionnaire` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`Questionnaire` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Auto increment questionaire id',
  `creatorid` INT NOT NULL COMMENT 'Author id(Users:id)',
  `name` VARCHAR(255) NOT NULL COMMENT 'Questionaire name',
  `description` VARCHAR(255) NOT NULL COMMENT 'Questionaire description',
  `language` VARCHAR(40) NOT NULL COMMENT 'Questionaire language',
  `public` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If questionaire accepted from one admin',
  `updated` TIMESTAMP NOT NULL COMMENT 'Questionaire last updated time.',
  PRIMARY KEY (`id`),
  INDEX `uid_idx` (`creatorid` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  CONSTRAINT `questionaire_creator_user_id`
    FOREIGN KEY (`creatorid`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`QuestionGroup`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`QuestionGroup` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`QuestionGroup` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Auto increment category id',
  `qid` INT NOT NULL COMMENT 'Quastionaires id (Quastionaires:id)',
  `name` VARCHAR(50) NOT NULL COMMENT 'Category name',
  `description` VARCHAR(255) NULL COMMENT 'Category description text. Can be null',
  `altitude` VARCHAR(11) NOT NULL,
  `longitude` VARCHAR(11) NOT NULL,
  `deviationA` VARCHAR(11) NOT NULL COMMENT 'Deviation altitude from location altitude',
  `deviationL` VARCHAR(11) NOT NULL COMMENT 'Deviation longitude from location longitude ',
  `updated` TIMESTAMP NOT NULL COMMENT 'Category last updated time.',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `qid_idx` (`qid` ASC),
  CONSTRAINT `questionGroup_questionaire_id`
    FOREIGN KEY (`qid`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`Question`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`Question` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`Question` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Auto increment question id',
  `gid` INT NOT NULL COMMENT 'QuestionGroups id (QuestionGroups:id)',
  `question` VARCHAR(255) NOT NULL COMMENT 'Question name',
  `time_to_answer` INT NOT NULL COMMENT 'Time for a user to answer one question',
  `updated` TIMESTAMP NOT NULL COMMENT 'Question last updated time.',
  PRIMARY KEY (`id`),
  INDEX `cid_idx` (`gid` ASC),
  UNIQUE INDEX `question_UNIQUE` (`question` ASC),
  CONSTRAINT `QuestionGroup_id_for_this_question`
    FOREIGN KEY (`gid`)
    REFERENCES `quizapp`.`QuestionGroup` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`Answer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`Answer` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`Answer` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT 'Auto increment id',
  `qid` INT NOT NULL COMMENT 'Question id (Questions:id)',
  `answer` VARCHAR(50) NOT NULL COMMENT 'Answer name',
  `description` VARCHAR(255) NULL COMMENT 'Answer description',
  `isCorrect` TINYINT(1) NOT NULL COMMENT 'if this answer is the correct for the question id',
  `updated` TIMESTAMP NOT NULL COMMENT 'when answer created',
  INDEX `qid_idx` (`qid` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `question_for_this_answer`
    FOREIGN KEY (`qid`)
    REFERENCES `quizapp`.`Question` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`UserAnswer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`UserAnswer` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`UserAnswer` (
  `uid` INT NOT NULL COMMENT 'User id (Users:id)',
  `aid` INT NOT NULL COMMENT 'Answer id (Answers:id)',
  `altitude` VARCHAR(10) NOT NULL COMMENT 'user altitude when he answer the question',
  `longitude` VARCHAR(10) NOT NULL COMMENT 'user longitude he answer the question',
  `answered_time` TIMESTAMP NOT NULL COMMENT 'When the question answered',
  INDEX `uid_idx` (`uid` ASC),
  INDEX `aid_idx` (`aid` ASC),
  PRIMARY KEY (`uid`, `aid`),
  CONSTRAINT `User_who_answer_this_question`
    FOREIGN KEY (`uid`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `answer_which_answered`
    FOREIGN KEY (`aid`)
    REFERENCES `quizapp`.`Answer` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`UserReport`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`UserReport` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`UserReport` (
  `uid` INT NOT NULL COMMENT 'user id (Users:id)',
  `quid` INT NOT NULL COMMENT 'Questionaires id (Questionaires:id)',
  `comment` VARCHAR(255) NOT NULL COMMENT 'Report comment from a user for a question id',
  `report_date` TIMESTAMP NOT NULL COMMENT 'Report date time',
  INDEX `uid_idx` (`uid` ASC),
  INDEX `qid_idx` (`quid` ASC),
  PRIMARY KEY (`uid`),
  CONSTRAINT `user_who_send_the_report`
    FOREIGN KEY (`uid`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `questionaire_reported`
    FOREIGN KEY (`quid`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`SubExaminer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`SubExaminer` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`SubExaminer` (
  `uid` INT NOT NULL COMMENT 'User id(Users:id)',
  `qid` INT NOT NULL COMMENT 'Question id(Questions:id)',
  `participation_time` TIMESTAMP NOT NULL,
  INDEX `uid_idx` (`uid` ASC),
  INDEX `qid_idx` (`qid` ASC),
  PRIMARY KEY (`uid`, `qid`),
  CONSTRAINT `user_access_request`
    FOREIGN KEY (`uid`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `questionaire_id_for_access`
    FOREIGN KEY (`qid`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`ExaminerApplication`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`ExaminerApplication` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`ExaminerApplication` (
  `uid` INT NOT NULL,
  `accept` TINYINT(1) NOT NULL DEFAULT 0,
  `time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `application_text` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`uid`),
  CONSTRAINT `examiner_application_foreign_key`
    FOREIGN KEY (`uid`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`PublishRequest`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`PublishRequest` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`PublishRequest` (
  `quastionnaire_id` INT NOT NULL,
  `request_time` TIMESTAMP NOT NULL,
  `response_time` TIMESTAMP NULL,
  `response` VARCHAR(45) NULL,
  `accept` TINYINT(1) NULL,
  PRIMARY KEY (`quastionnaire_id`, `request_time`),
  CONSTRAINT `fk_publish_questionnaire`
    FOREIGN KEY (`quastionnaire_id`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`ExaminerParticipationRequest`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`ExaminerParticipationRequest` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`ExaminerParticipationRequest` (
  `examiner_id` INT NOT NULL,
  `questionnaire_id` INT NOT NULL,
  `request_time` TIMESTAMP NOT NULL,
  `request_text` VARCHAR(45) NOT NULL,
  `accepted` TINYINT(1) NULL,
  PRIMARY KEY (`examiner_id`, `questionnaire_id`, `request_time`),
  INDEX `fk_examiner_request_questionnaire_idx` (`questionnaire_id` ASC),
  CONSTRAINT `fk_examiner_request_user`
    FOREIGN KEY (`examiner_id`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_examiner_request_questionnaire`
    FOREIGN KEY (`questionnaire_id`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`CanPlay`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`CanPlay` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`CanPlay` (
  `uid` INT NOT NULL,
  `qid` INT NOT NULL,
  `comment` VARCHAR(100) NOT NULL,
  `request_time` TIMESTAMP NOT NULL,
  `accepted` TINYINT(1) NOT NULL,
  PRIMARY KEY (`uid`, `qid`),
  INDEX `fk_CanPlay_2_idx` (`qid` ASC),
  CONSTRAINT `fk_CanPlay_1`
    FOREIGN KEY (`uid`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_CanPlay_2`
    FOREIGN KEY (`qid`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `quizapp`.`AccessLevel`
-- -----------------------------------------------------
START TRANSACTION;
USE `quizapp`;
INSERT INTO `quizapp`.`AccessLevel` (`name`, `updated`) VALUES ('Player', 'CURRENT_TIMESTAMP');
INSERT INTO `quizapp`.`AccessLevel` (`name`, `updated`) VALUES ('Examiner', 'CURRENT_TIMESTAMP');
INSERT INTO `quizapp`.`AccessLevel` (`name`, `updated`) VALUES ('Moderator', 'CURRENT_TIMESTAMP');

COMMIT;
