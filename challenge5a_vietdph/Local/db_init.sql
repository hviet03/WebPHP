CREATE DATABASE CodeAndPunch;
USE CodeAndPunch;
CREATE TABLE information (
user_id int(11) NOT NULL primary key AUTO_INCREMENT unique,
username nvarchar(50) not null,
role boolean,
password nvarchar(255) not null,
full_name nvarchar(50),
email nvarchar(100),
phone_num varchar(10));

INSERT INTO information ()
VALUES
(1,'student01', 0, 'c0b1d84fd16d13bf53eb5e8b2c197565b569855240b59ad4b7b812df946534c4', N'Học Sinh 1', 'student1@gmail.com', '0987123456'),
(2,'studen02', 0, 'c0b1d84fd16d13bf53eb5e8b2c197565b569855240b59ad4b7b812df946534c4', N'Học Sinh 2', 'student2@gmail.com', '0999888999'),
(3,'teacher01', 1, 'c0b1d84fd16d13bf53eb5e8b2c197565b569855240b59ad4b7b812df946534c4', N'Giáo viên 1', 'teacher1@gmail.com', '0999999999'),
(4,'teacher02', 1, 'c0b1d84fd16d13bf53eb5e8b2c197565b569855240b59ad4b7b812df946534c4', N'Giáo viên 2', 'teacher2@gmail.com', '0123456789'),




CREATE TABLE `homework` (`homework_id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT , `tittle` NVARCHAR(255) ,`description` NVARCHAR(512) ,`file_name` NVARCHAR(512) ,  `date` DATE , `current_submission` INT(11) ) ENGINE = InnoDB;
INSERT INTO `homework` ()
VALUES ('1', 'First test','This is a first test for you','test.txt',  '2023-05-31', '0')


CREATE TABLE `student_homework` (`student_id` INT(11), `homework_id` INT(11), `file_name` NVARCHAR(512)) ENGINE = InnoDB;
