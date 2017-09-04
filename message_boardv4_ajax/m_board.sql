/**
  留言板数据库设计

 */
CREATE TABLE `m_board`
(
  `m_id` INT NOT NULL auto_increment,
  `user_name` varchar(64) NOT NULL DEFAULT '',
  `content` VARCHAR(2048) NOT NULL DEFAULT '',
  `ctime` INT unsigned NOT NULL DEFAULT 0,
  PRIMARY KEY(`m_id`)
)engine=innodb DEFAULT charset=utf8;