-- MySQL Script generated by MySQL Workbench
-- Mon 11 Apr 2016 07:47:25 PM EEST
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
  `id` INT(1) NOT NULL COMMENT 'Auto increment access level id',
  `name` VARCHAR(20) NOT NULL COMMENT 'Access level name',
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
  `api_token` VARCHAR(40) NOT NULL,
  `access` INT(1) NOT NULL COMMENT 'Access level id (Access:id)',
  `name` VARCHAR(40) NOT NULL COMMENT 'The real name from a user',
  `surname` VARCHAR(40) NOT NULL COMMENT 'The real surname from a user',
  `gender` INT(1) NOT NULL,
  `country` VARCHAR(40) NOT NULL COMMENT 'Country name where the user lives.Can be null',
  `city` VARCHAR(40) NOT NULL COMMENT 'City name where the user lives.Can be null',
  `address` VARCHAR(40) NULL COMMENT 'Home address from a user.Can be null',
  `phone` VARCHAR(15) NULL COMMENT 'The phone number from a user.Can be null',
  `last_login` TIMESTAMP NOT NULL COMMENT 'Last login date from the user.',
  `verified` INT(1) NOT NULL DEFAULT 0,
  `banned` INT(1) NOT NULL DEFAULT 0,
  `deleted` INT(1) NOT NULL DEFAULT 0,
  `email_verification_token` VARCHAR(40) NULL,
  `email_verification_date` TIMESTAMP NULL,
  `password_recovery_token` VARCHAR(40) NULL,
  `password_recovery_date` TIMESTAMP NULL,
  `new_email` VARCHAR(50) NULL,
  PRIMARY KEY (`id`),
  INDEX `alvl_idx` (`access` ASC),
  UNIQUE INDEX `email_verification_token_UNIQUE` (`email_verification_token` ASC),
  UNIQUE INDEX `password_recovery_token_UNIQUE` (`password_recovery_token` ASC),
  UNIQUE INDEX `api_token_UNIQUE` (`api_token` ASC),
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
  `coordinator_id` INT NOT NULL COMMENT 'Author id(Users:id)',
  `name` VARCHAR(255) NOT NULL COMMENT 'Questionaire name',
  `description` VARCHAR(255) NOT NULL COMMENT 'Questionaire description',
  `public` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'If questionaire accepted from one admin',
  `message_required` INT NOT NULL DEFAULT 0,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Questionaire last updated time.',
  PRIMARY KEY (`id`),
  INDEX `uid_idx` (`coordinator_id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  CONSTRAINT `questionaire_creator_user_id`
    FOREIGN KEY (`coordinator_id`)
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
  `questionnaire_id` INT NOT NULL COMMENT 'Quastionaires id (Quastionaires:id)',
  `name` VARCHAR(50) NOT NULL COMMENT 'Category name',
  `latitude` FLOAT NOT NULL,
  `longitude` FLOAT NOT NULL,
  `radius` FLOAT NOT NULL COMMENT 'Deviation longitude from location longitude ',
  `creation_date` TIMESTAMP NOT NULL COMMENT 'Category last updated time.',
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC),
  INDEX `qid_idx` (`questionnaire_id` ASC),
  CONSTRAINT `questionGroup_questionaire_id`
    FOREIGN KEY (`questionnaire_id`)
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
  `question_group_id` INT NOT NULL COMMENT 'QuestionGroups id (QuestionGroups:id)',
  `question` VARCHAR(255) NOT NULL COMMENT 'Question name',
  `time_to_answer` INT NOT NULL COMMENT 'Time for a user to answer one question',
  `creation_date` TIMESTAMP NOT NULL COMMENT 'Question last updated time.',
  `multiplier` FLOAT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX `cid_idx` (`question_group_id` ASC),
  UNIQUE INDEX `question_UNIQUE` (`question` ASC),
  CONSTRAINT `QuestionGroup_id_for_this_question`
    FOREIGN KEY (`question_group_id`)
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
  `question_id` INT NOT NULL COMMENT 'Question id (Questions:id)',
  `answer` VARCHAR(50) NOT NULL COMMENT 'Answer name',
  `description` VARCHAR(255) NULL COMMENT 'Answer description',
  `is_correct` TINYINT(1) NOT NULL COMMENT 'if this answer is the correct for the question id',
  `creation_date` TIMESTAMP NOT NULL COMMENT 'when answer created',
  INDEX `qid_idx` (`question_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `question_for_this_answer`
    FOREIGN KEY (`question_id`)
    REFERENCES `quizapp`.`Question` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`UserAnswer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`UserAnswer` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`UserAnswer` (
  `user_id` INT NOT NULL COMMENT 'User id (Users:id)',
  `answer_id` INT NOT NULL COMMENT 'Answer id (Answers:id)',
  `question_id` INT NOT NULL,
  `latitude` FLOAT NOT NULL COMMENT 'user altitude when he answer the question',
  `longitude` FLOAT NOT NULL COMMENT 'user longitude he answer the question',
  `answered_time` TIMESTAMP NOT NULL COMMENT 'When the question answered',
  `is_correct` INT NOT NULL,
  INDEX `uid_idx` (`user_id` ASC),
  INDEX `aid_idx` (`answer_id` ASC),
  PRIMARY KEY (`user_id`, `answer_id`, `question_id`),
  INDEX `question_user_answer_fk_idx` (`question_id` ASC),
  CONSTRAINT `User_who_answer_this_question`
    FOREIGN KEY (`user_id`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `answer_which_answered`
    FOREIGN KEY (`answer_id`)
    REFERENCES `quizapp`.`Answer` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `question_user_answer_fk`
    FOREIGN KEY (`question_id`)
    REFERENCES `quizapp`.`Question` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`UserReport`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`UserReport` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`UserReport` (
  `user_id` INT NOT NULL COMMENT 'user id (Users:id)',
  `question_id` INT NOT NULL COMMENT 'Questionaires id (Questionaires:id)',
  `comment` VARCHAR(255) NOT NULL COMMENT 'Report comment from a user for a question id',
  `report_date` TIMESTAMP NOT NULL COMMENT 'Report date time',
  INDEX `uid_idx` (`user_id` ASC),
  INDEX `qid_idx` (`question_id` ASC),
  PRIMARY KEY (`user_id`, `question_id`),
  CONSTRAINT `user_who_send_the_report`
    FOREIGN KEY (`user_id`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `questionaire_reported`
    FOREIGN KEY (`question_id`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`ExaminerApplication`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`ExaminerApplication` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`ExaminerApplication` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `accepted` TINYINT(1) NULL DEFAULT 0,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `application_text` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `examiner_application_foreign_key`
    FOREIGN KEY (`user_id`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`QuestionnaireRequest`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`QuestionnaireRequest` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`QuestionnaireRequest` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `questionnaire_id` INT NOT NULL,
  `request_type` INT NOT NULL,
  `request_text` VARCHAR(255) NULL,
  `request_date` TIMESTAMP NOT NULL,
  `response_text` VARCHAR(255) NULL,
  `accepted` INT(1) NULL,
  PRIMARY KEY (`id`),
  INDEX `request_user_fk_idx` (`user_id` ASC),
  INDEX `request_questionnaire_fk_idx` (`questionnaire_id` ASC),
  CONSTRAINT `request_user_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `request_questionnaire_fk`
    FOREIGN KEY (`questionnaire_id`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`QuestionnaireParticipation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`QuestionnaireParticipation` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`QuestionnaireParticipation` (
  `user_id` INT NOT NULL,
  `questionnaire_id` INT NOT NULL,
  `participation_type` INT NOT NULL,
  `participation_date` TIMESTAMP NOT NULL,
  PRIMARY KEY (`questionnaire_id`, `participation_type`, `user_id`),
  INDEX `participation_questionnaire_fk_idx` (`questionnaire_id` ASC),
  CONSTRAINT `participation_user_fk`
    FOREIGN KEY (`user_id`)
    REFERENCES `quizapp`.`User` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `participation_questionnaire_fk`
    FOREIGN KEY (`questionnaire_id`)
    REFERENCES `quizapp`.`Questionnaire` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quizapp`.`QuestionnaireSchedule`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `quizapp`.`QuestionnaireSchedule` ;

CREATE TABLE IF NOT EXISTS `quizapp`.`QuestionnaireSchedule` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `questionnaire_id` INT NOT NULL,
  `day` INT NULL,
  `start_time` INT NOT NULL,
  `start_date` DATE NULL,
  `end_time` INT NOT NULL,
  `end_date` DATE NULL,
  PRIMARY KEY (`id`),
  INDEX `questionnaire_schedule_fk_idx` (`questionnaire_id` ASC),
  CONSTRAINT `questionnaire_schedule_fk`
    FOREIGN KEY (`questionnaire_id`)
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
INSERT INTO `quizapp`.`AccessLevel` (`id`, `name`) VALUES (1, 'Player');
INSERT INTO `quizapp`.`AccessLevel` (`id`, `name`) VALUES (2, 'Examiner');
INSERT INTO `quizapp`.`AccessLevel` (`id`, `name`) VALUES (3, 'Moderator');

COMMIT;

