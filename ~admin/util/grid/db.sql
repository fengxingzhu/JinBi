CREATE TABLE `{TAG_DBNAME}` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`__typeid` VARCHAR( 100 ) NOT NULL ,
`__aurl` VARCHAR( 255 ) NOT NULL ,
`__hurl` VARCHAR( 255 ) NOT NULL ,
`__alltname` TEXT NOT NULL ,
`__alltname_key` TEXT NOT NULL ,
`__allapp_ids` TEXT NOT NULL ,
`__syninfo` INT NOT NULL,
`__handsort` INT NOT NULL,
`__systop` TINYINT NOT NULL,
`__syspub` TINYINT NOT NULL,
INDEX ( `__typeid` ) 
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_unicode_ci;