<?
return [
  "ALTER TABLE `{Prefix}users` ADD `faceid_enrolled` BOOLEAN NOT NULL DEFAULT FALSE AFTER `user_status`",
  "ALTER TABLE `{Prefix}users` ADD `faceid_hash` VARCHAR(900) NULL AFTER `user_status`",
  "ALTER TABLE `{Prefix}users` ADD `faceid` BOOLEAN NOT NULL DEFAULT FALSE AFTER `user_status`"
];
