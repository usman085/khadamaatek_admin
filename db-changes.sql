-- 9/14/2020
ALTER TABLE `services`
	ADD COLUMN `service_detail` TEXT NULL AFTER `name`;


-- 9/15/2020
ALTER TABLE `users`
	ADD COLUMN `device_token` VARCHAR(200) NULL DEFAULT NULL AFTER `remember_token`,
	ADD COLUMN `device_type` VARCHAR(100) NULL DEFAULT NULL AFTER `device_token`;

ALTER TABLE `customers`
	ADD COLUMN `device_token` VARCHAR(200) NULL DEFAULT NULL AFTER `verified`,
	ADD COLUMN `device_type` VARCHAR(100) NULL DEFAULT NULL AFTER `device_token`;


-- 9/18/2020
ALTER TABLE `customer_documents`
	ADD UNIQUE INDEX `name` (`name`);


-- 10/09/2020
ALTER TABLE `orders`
	ADD COLUMN `expiry_date` DATE NULL DEFAULT NULL AFTER `proof_img`;
