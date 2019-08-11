CREATE TABLE user (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `amount` NUMERIC(10, 2) DEFAULT NULL,
  PRIMARY KEY(`id`)) DEFAULT CHARACTER SET UTF8 COLLATE UTF8_unicode_ci ENGINE = InnoDB;
INSERT INTO user(login, password, username, amount) VALUES ('%s', '%s', '%s', %s);