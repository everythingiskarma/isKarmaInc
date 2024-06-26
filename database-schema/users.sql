CREATE DATABASE IF NOT EXISTS `iskarmac_users`; USE `iskarmac_users`;


CREATE TABLE IF NOT EXISTS `gatekeeper` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `email` varchar(255) NOT NULL COMMENT '',
    `domain` varchar(255) NOT NULL COMMENT '',
    `verified` int(1) NOT NULL DEFAULT 0 COMMENT '',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `otp` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `otp` int(6) DEFAULT NULL COMMENT '',
    `type` int(1) NOT NULL DEFAULT 0 COMMENT '0 = gatekeeper,  1 = registered',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '0 = unverified,  1 = verified',
    `attempts` int(1) NOT NULL DEFAULT 0 COMMENT 'max 4 attempts allowed',
    `date_issued` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'auto updates on resends',
    UNIQUE KEY `uid` (`uid`),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci  COMMENT '';


CREATE TABLE IF NOT EXISTS `sessions` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `uid` varchar(16) NOT NULL,
    `session` varchar(255) DEFAULT NULL COMMENT 'session id generated by the server',
    `ip` varchar(45) DEFAULT NULL COMMENT 'ip addr of user',
    `country` varchar(120) DEFAULT NULL COMMENT 'country of user',
    `os` varchar(50) DEFAULT NULL COMMENT '',
    `os_version` varchar(50) DEFAULT NULL COMMENT '',
    `timezone` varchar(255) DEFAULT NULL COMMENT '',
    `browser` varchar(255) DEFAULT NULL COMMENT '',
    `browser_version` varchar(255) DEFAULT NULL COMMENT '',
    `method` varchar(255) DEFAULT NULL COMMENT '',
    `domain` varchar(255) DEFAULT NULL COMMENT '',
    `referrer` varchar(255) DEFAULT NULL COMMENT '',
    `agent` varchar(255) DEFAULT NULL COMMENT '',
    `speed` varchar(255) DEFAULT NULL COMMENT '',
    `device` varchar(255) DEFAULT NULL COMMENT '',
    `status` int(1) DEFAULT 0 COMMENT 'show current login status',
    `login_time` datetime DEFAULT NULL COMMENT '',
    `logout_time` datetime DEFAULT NULL COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci  COMMENT '';


CREATE TABLE IF NOT EXISTS `user` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `email` varchar(255) NOT NULL COMMENT '',
    `domain` varchar(255) NOT NULL COMMENT '',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT '',
    `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`),
    UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `kyc` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `email_alt` varchar(255) NULL COMMENT '',
    `firstname` varchar(255) NULL COMMENT 'enter your firstname',
    `lastname` varchar(255) NULL COMMENT 'enter your lastname',
    `gender` int(1) NOT NULL DEFAULT 0 COMMENT '',
    `dob` varchar(20) DEFAULT NULL COMMENT '',
    `cc` varchar(20) DEFAULT NULL COMMENT '',
    `cn` varchar(20) DEFAULT NULL COMMENT '',
    `dc` varchar(20) DEFAULT NULL COMMENT '',
    `mobile` varchar(20) DEFAULT NULL COMMENT '',
    `id_type` varchar(255) DEFAULT NULL COMMENT 'citizenship, driving license, voters id, passport, pancard, aadhar card',
    `id_image` varchar(255) DEFAULT NULL COMMENT '',
    `id_address_proof` varchar(255) DEFAULT NULL COMMENT 'utility bill, bank statement, rent agreement, govt id',
    `id_address_proof_image` varchar(255) DEFAULT NULL COMMENT 'upload document max 2mb (pdf, jpeg, png)',
    `id_kyc_status` int(1) DEFAULT 0 COMMENT 'to be set by our security',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `address` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `type` int(1) NOT NULL DEFAULT 0 COMMENT '1 = home / 2 = office / 3 = other',
    `priority` int(1) NOT NULL DEFAULT 0 COMMENT '1 = primary, 2 = secondary',
    `label` varchar(50) NULL COMMENT 'nickname to identify multiple addresses',
    `address` varchar(255) NULL COMMENT '',
    `country` varchar(120) NULL COMMENT '',
    `state` varchar(120) NULL COMMENT '',
    `city` varchar(120) NULL COMMENT '',
    `zip` varchar(20) NULL COMMENT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `kyc_business` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `biz_name` varchar(255) DEFAULT NULL COMMENT 'name of business or organization',
    `biz_role` varchar(255) DEFAULT NULL COMMENT 'users role in business',
    `biz_type` varchar(255) DEFAULT NULL COMMENT 'select list of types of biz - manufacturing, services, retail etc.',
    `biz_industry` varchar(255) DEFAULT NULL COMMENT 'select list of types of industries - agri, solar, textile etc',
    `biz_category` varchar(255) DEFAULT NULL COMMENT 'select list of category based on industry',
    `biz_reg_type` varchar(255) DEFAULT NULL COMMENT 'proprietorship, partnership, limted liability company, corporation, non-profit, co-operative',
    `biz_reg_cert_image` varchar(255) DEFAULT NULL COMMENT 'govt issued business registatration certificate (image)',
    `biz_validity` varchar(255) DEFAULT NULL COMMENT 'validity of registatration as on certificate',
    `biz_annual_income` varchar(255) DEFAULT NULL COMMENT 'validity of certificate',
    `biz_total_employees` varchar(255) DEFAULT NULL COMMENT 'validity of certificate',
    `biz_kyc_status` int(1) DEFAULT 0 COMMENT 'to be set by our security',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `preferences` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `language` varchar(11) DEFAULT 0 COMMENT '',
    `mode` int(1) DEFAULT 0 COMMENT '',
    `timezone` int(1) DEFAULT 0 COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `communication` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status_newsletter` int(11) DEFAULT 0 COMMENT '',
    `status_notifications` int(11) DEFAULT 0 COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `security` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `two_factor` int(1) DEFAULT 0 COMMENT '',
    `two_factor_key` varchar(255) DEFAULT NULL COMMENT '',
    `status_terms` int(11) DEFAULT 0 COMMENT '',
    `status_privacy` int(11) DEFAULT 0 COMMENT '',
    `status_multisite` int(11) DEFAULT 0 COMMENT '',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`),
    UNIQUE KEY `two_factor_key` (`two_factor_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';


CREATE TABLE IF NOT EXISTS `select_list_options_json` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `biz_type` varchar(255) DEFAULT NULL COMMENT '',
    `biz_industry` varchar(255) DEFAULT NULL COMMENT '',
    `biz_category` varchar(255) DEFAULT NULL COMMENT '',
    `countries` varchar(255) DEFAULT NULL COMMENT '',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT 'build a tool to manage these fields and options */ /* json arrary of options';
