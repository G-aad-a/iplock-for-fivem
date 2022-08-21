CREATE DATABASE `custom_lock` IF NOT EXISTS 

USE `custom_lock`

CREATE TABLE `keys` (
  `id` int not null PRIMARY key AUTO_INCREMENT,
  `key` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `used` tinyint(1) NOT NULL DEFAULT 0,
  `script_id` int(11) NOT NULL,
  `disabled` BOOLEAN not null default 0,
  `author` varchar(255) default "unknown"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `whitelisted` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `script_id` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `servername` varchar(255) NOT NULL,
  `discord` varchar(255) DEFAULT NULL,
  `expires` varchar(255) NOT NULL,
  `disabled` BOOLEAN not null default 0,
  `key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


