/* Drop and create whole database */
DROP DATABASE IF EXISTS `tb-test`;
CREATE DATABASE IF NOT EXISTS `tb-test`;


/* Go to created database */
USE `tb-test`;


/* Drop and create tables for the database */
DROP TABLE IF EXISTS `articles_categories`;
DROP TABLE IF EXISTS `articles`;
DROP TABLE IF EXISTS `categories`;

CREATE TABLE IF NOT EXISTS `articles` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `SKU` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'SKU (article number)',
    `EAN` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'EAN (European article number)',
    `name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Name',
    `stock_quantity` INT(10) NOT NULL DEFAULT 0 COMMENT 'Stock quantity',
    `price` DECIMAL(10,2) NOT NULL DEFAULT 0.00 COMMENT 'Price',
    PRIMARY KEY (`id`),
    UNIQUE KEY (`SKU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Articles table';

CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `parent_id` INT(10) UNSIGNED DEFAULT NULL,
    `level` INT(10) UNSIGNED NOT NULL DEFAULT 0,
    `name` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Name',
    PRIMARY KEY (`id`),
    KEY `parent_id` (`parent_id`),
    FOREIGN KEY (`parent_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Categories table';

CREATE TABLE IF NOT EXISTS `articles_categories` (
    `article_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
    `category_id` INT(10) UNSIGNED NOT NULL DEFAULT 0,
    UNIQUE INDEX `article_id` (`article_id`, `category_id`),
    FOREIGN KEY (`article_id`)
        REFERENCES `articles` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Pivot table between articles and categories';
