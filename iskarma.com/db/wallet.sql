CREATE DATABASE IF NOT EXISTS `iskarmac_wallet`; USE `iskarmac_wallet`;

/**************************************************************************************/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~// LISTED CURRENCIES //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**************************************************************************************/
CREATE TABLE IF NOT EXISTS `wallet_currencies` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `name` varchar(255) DEFAULT NULL COMMENT 'name of currency',
    `code` varchar(3) DEFAULT NULL COMMENT '3 letter currency code',
	`value` int(11) NOT NULL DEFAULT 0 COMMENT 'karma value as per last update',
	`status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = enabled, 2 = disabled',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'auto updates',
    PRIMARY KEY (`id`),
    UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/**************************************************************************************/


/**************************************************************************************/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~// STORED PAYMENT METHOD //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**************************************************************************************/
CREATE TABLE IF NOT EXISTS `wallet_deposit_method` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `currency` varchar(3) DEFAULT NULL COMMENT '3 letter currency code',
    `method` varchar(255) DEFAULT NULL COMMENT '1=Debit Card, 2=CreditCard, 3=Bank Transfer, 4=eWallets, 5=cash',
	`status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = enabled, 2 = disabled',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'auto updates',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/**************************************************************************************/


/**************************************************************************************/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~// LINKED BANK ACCOUNT //~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**************************************************************************************/
CREATE TABLE IF NOT EXISTS `wallet_withdrawal_account` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `currency` varchar(3) DEFAULT NULL COMMENT '3 letter currency code',
    `type` int(1) NOT NULL DEFAULT 0 COMMENT '1 = Personal, 2 = Business, 3 = Special',
    `special` int(1) NOT NULL DEFAULT 0 COMMENT '1 = Student, 2 = Senior Citizen, 3 = Trust, 4 = Non-Profit, 5 = Other',
	`status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = enabled, 2 = disabled',
    `name` varchar(255) DEFAULT NULL COMMENT 'recipient/business name who owns the bank account',
    `account` varchar(255) DEFAULT NULL COMMENT 'bank account number',
    `iban` varchar(255) DEFAULT NULL COMMENT 'international bank account number',
    `bank` varchar(255) DEFAULT NULL COMMENT 'bank name',
    `bank_branch` varchar(255) DEFAULT NULL COMMENT 'bank branch name',
    `bank_branch_address` varchar(255) DEFAULT NULL COMMENT 'physical address of the bank branch',
    `routing` varchar(255) DEFAULT NULL COMMENT 'bank routing number to identify the branch',
    `swift` varchar(255) DEFAULT NULL COMMENT 'bank swift code',
    `bic` varchar(255) DEFAULT NULL COMMENT 'bank identifier code',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'when created',
    `updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'when last updated',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/**************************************************************************************/


/**************************************************************************************/
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~// WALLET [LEDGER BALANCE] //~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**************************************************************************************/
CREATE TABLE IF NOT EXISTS `wallet_balance` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '',
    `uid` varchar(16) NOT NULL COMMENT '',
    `balance` int(11) NOT NULL DEFAULT 0 COMMENT 'aggregated karma credits',
    `currency` varchar(3) DEFAULT NULL COMMENT 'default preferred local currency',
    `secret` varchar(255) DEFAULT NULL COMMENT 'secret access code for wallet',
	`status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = enabled, 2 = disabled, 3 = on hold, 4 = restricted',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/**************************************************************************************/


/**************************************************************************************/
/*++++++++++++++++++++++++++++++++// POSITIVE FUNDS //++++++++++++++++++++++++++++++++*/
/**************************************************************************************/

/*+++++++++++++++++++++++++++ DIRECT DEPOSITS INTO WALLET ++++++++++++++++++++++++++++*/
CREATE TABLE IF NOT EXISTS `credit_deposits` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT 'uid of beneficiary',
    `wid` varchar(11) NOT NULL COMMENT 'wallet id of beneficiary',
    `uid_source` varchar(16) NOT NULL COMMENT 'uid of depositor',
    `currency` varchar(3) DEFAULT NULL COMMENT '3 letter currency code',
    `amount` int(11) DEFAULT NULL COMMENT 'amount in selected currency',
    `karma_rate` int(11) DEFAULT NULL COMMENT 'current 1 karma credit rate against selected currency',
    `karma_in` int(11) DEFAULT NULL COMMENT 'total karma credits added against deposit',
    `note` varchar(255) DEFAULT NULL COMMENT 'personal note by the depositor',
    `method` varchar(255) DEFAULT NULL COMMENT 'payment method of deposit',
    `gateway` varchar(255) DEFAULT NULL COMMENT 'payment gateway used for transaction',
    `gateway_id` varchar(255) DEFAULT NULL COMMENT 'payment gateway transaction reference number',
    `summary` varchar(255) DEFAULT NULL COMMENT 'system generated transaction summary',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = pending, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*+++++++++++++++++++ EARNINGS FROM DIRECT SALES IN THE ECOSYSTEM ++++++++++++++++++++*/
CREATE TABLE IF NOT EXISTS `credit_sales` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `uid_buyer` varchar(16) NOT NULL COMMENT 'uid of the buyer who purchased the product or service',
	`id_store` int(11) NOT NULL COMMENT 'store id where the product or service was sold',
 	`id_order` int(11) NOT NULL COMMENT 'order id of the product or service sold',
    `karma` int(11) NOT NULL DEFAULT 0 COMMENT 'total karma credit recieved from sale',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*+++++++++++++++++++++ COMMISSIONS EARNED THROUGH INDIRECT SALES ++++++++++++++++++++*/
CREATE TABLE IF NOT EXISTS `credit_commissions` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*+++++++++++++++++++++++++ REWARDS EARNED THROUGH ACTIVITIES ++++++++++++++++++++++++*/
CREATE TABLE IF NOT EXISTS `credit_rewards` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/*------------------------- CREDIT FROM VOLUNTARY DONATIONS ---------------------------*/
CREATE TABLE IF NOT EXISTS `credit_donations` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `karma` int(11) NOT NULL DEFAULT 0 COMMENT 'total karma credits recieived as donation',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*++++++++++++++++++++++ DIRECT CREDIT TRANSFER FROM ANOTHER USER ++++++++++++++++++++*/
CREATE TABLE IF NOT EXISTS `credit_transfers` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/

/**************************************************************************************/
/*--------------------------------// NEGATIVE FUNDS //--------------------------------*/
/**************************************************************************************/

/*---------------------- DIRECT WITHDRAWAL TO USERS BANK ACCOUNT ---------------------*/
CREATE TABLE IF NOT EXISTS `debit_withdrawals` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT 'uid of withdrawer',
    `wid` varchar(11) NOT NULL COMMENT 'wallet id of withdrawer',
    `currency` varchar(3) DEFAULT NULL COMMENT '3 letter currency code',
    `amount` int(11) NOT NULL DEFAULT 0 COMMENT 'amount in selected currency',
    `karma_rate` int(11) NOT NULL DEFAULT 0 COMMENT 'current 1 karma credit rate against selected currency',
    `karma_out` int(11) NOT NULL DEFAULT 0 COMMENT 'total karma credits deducted against withdrawal',
    `note` varchar(255) DEFAULT NULL COMMENT 'personal note by the depositor',
    `method` varchar(255) DEFAULT NULL COMMENT 'payment method of withdrawal',
    `gateway` varchar(255) DEFAULT NULL COMMENT 'payment gateway used for transaction',
    `gateway_id` varchar(255) DEFAULT NULL COMMENT 'payment gateway transaction reference number',
    `summary` varchar(255) DEFAULT NULL COMMENT 'system generated transaction summary',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = pending, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*---------------------- DIRECT DEBIT TRANSFER TO ANOTHER USER ----------------------*/
CREATE TABLE IF NOT EXISTS `debit_transfers` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `karma` int(11) NOT NULL DEFAULT 0 COMMENT 'total karma credits transferred to another user',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*------------------------- DEBIT FROM PURCHASES MADE BY USER ------------------------*/
CREATE TABLE IF NOT EXISTS `debit_purchases` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `karma` int(11) NOT NULL DEFAULT 0 COMMENT 'total karma credits debited towards the purchase',
    `uid_seller` varchar(16) NOT NULL COMMENT 'uid of the seller who sold the product or service',
	`id_store` int(11) NOT NULL COMMENT 'store id where the product or service was sold',
 	`id_order` int(11) NOT NULL COMMENT 'order id of the product or service sold',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*------------------- DEBIT FROM ONE-TIME/RECURRING SUBSCRIPTIONS --------------------*/
CREATE TABLE IF NOT EXISTS `debit_subscriptions` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*------------------------- DEBIT FROM VOLUNTARY DONATIONS ---------------------------*/
CREATE TABLE IF NOT EXISTS `debit_donations` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*------------ DEBIT FROM COMMISSIONS PAID TO RESELLER/DROP SHIPPER/ETC --------------*/
CREATE TABLE IF NOT EXISTS `debit_commissions` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/

/*------------ DEBIT FROM PAYMENTS MADE TOWARDS SERVICES/BILLS/UTILITIES --------------*/
CREATE TABLE IF NOT EXISTS `debit_payments` (
    `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'transaction id',
    `uid` varchar(16) NOT NULL COMMENT '',
    `status` int(1) NOT NULL DEFAULT 0 COMMENT '1 = completed, 2 = on hold, 3 = cancelled, 4 = refunded',
    `created` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'timestamp of transaction',
    PRIMARY KEY (`id`),
    UNIQUE KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT '';
/*------------------------------------------------------------------------------------*/