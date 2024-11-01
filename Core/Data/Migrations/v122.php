<?
return [
  "CREATE TABLE IF NOT EXISTS {Prefix}SFADailyReports (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    DayFormat VARCHAR(100) NULL,
    Attacks int(32) NULL DEFAULT '0',
    SQLAttacks int(32) NULL DEFAULT '0',
    DDoSAttacks int(32) NULL DEFAULT '0',
    Logins int(32) NULL DEFAULT '0',
    Bans int(32) NULL DEFAULT '0',
    stamp TIMESTAMP)",

  "ALTER TABLE `{Prefix}SFAIPBans` ADD `banid` VARCHAR(200) NULL AFTER `performer`",
  "ALTER TABLE `{Prefix}SFAIPBans` ADD `unbanid` VARCHAR(200) NULL AFTER `banid`",
  "ALTER TABLE `{Prefix}SFAIPBans` ADD `cfbanned` BOOLEAN NOT NULL DEFAULT FALSE AFTER `unbanid`",
  "ALTER TABLE `{Prefix}users` ADD `faceid_enrolled` BOOLEAN NOT NULL DEFAULT FALSE AFTER `user_status`",
  "ALTER TABLE `{Prefix}users` ADD `faceid_hash` VARCHAR(900) NULL AFTER `user_status`",
  "ALTER TABLE `{Prefix}users` ADD `faceid` BOOLEAN NOT NULL DEFAULT FALSE AFTER `user_status`"
];
