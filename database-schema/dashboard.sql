CREATE DATABASE IF NOT EXISTS `iskarmac_dashboard`; USE `iskarmac_dashboard`;

CREATE TABLE IF NOT EXISTS `shortcuts` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
	
    UNIQUE KEY `uid` (`uid`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci  COMMENT '';

